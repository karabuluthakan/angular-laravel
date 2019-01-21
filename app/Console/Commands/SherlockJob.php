<?php

namespace App\Console\Commands;

use App\Libraries\Elasticsearch;
use App\Term;
use Illuminate\Console\Command;

class SherlockJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sherlock:job {what}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sherlock jobs';

    protected $elasticsearch;

    /**
     * Create a new command instance.
     * @param App\Libraries\Elasticsearch
     * @return void
     */
    public function __construct(Elasticsearch $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        switch ($this->argument('what')) {
            case 'elasticsearchSelectCategoriesIndex':
                $this->elasticsearchSelectCategoriesIndex();
                break;
            case 'angularFiles':
                $this->angularFiles();
                break;
        }
    }

    protected function elasticsearchSelectCategoriesIndex()
    {
        $categories = Term::where('type', Term::TYPE_CATEGORY)
            ->orderBy('parent')
            ->get();

        $_categories = [];
        foreach ($categories as $category) {
            if (!isset($category->parent))
                $category->parent = 0;

            $_categories[$category->id] = $category;
        }

        $categoriesList = Term::getTermsList($categories);
        foreach ($categoriesList as $id => $name) {
            $category = $_categories[$id];
            $category->pathName = $name;

            $this->elasticsearch
                ->indexSelectCategory($category);
        }
    }

    protected function angularFiles()
    {
        $path = public_path('js/backend.angular');
        if (($handle = opendir($path)) !== false) {
            while ($file = readdir($handle)) {
                if (!in_array(substr($file, -3), ['.js', 'css'])) {
                    if (is_file($path . '/' . $file))
                        unlink($path . '/' . $file);

                    continue;
                }

                $fileNew = explode('.', $file);
                rename($path . '/' . $file, $path . '/' . $fileNew[0] . '.' . $fileNew[2]);
            }
        }
    }
}
