import {Component, EventEmitter, Input, OnInit, Output, ViewChildren} from '@angular/core';
import {MainService} from "../services/main.service";
import {IResponse} from "../interfaces/iresponse";
import {ICategory} from "../interfaces/icategory";
import {FormControl} from "@angular/forms";
import {debounceTime} from "rxjs/operators";
import {of} from "rxjs";

@Component({
  selector: 'app-categories',
  templateUrl: './categories.component.html'
})
export class CategoriesComponent implements OnInit {

  level = 0;
  levels = {};
  category: ICategory;
  delCategory: ICategory;

  searchParent: FormControl = new FormControl();
  searchResult = {
    parentCategory: [

    ],
    categories: [

    ]
  };

  results: IResponse[] = [
      {
          status: 0,
          message: "",
          data: {
              parentCategory: {
                  id: 0,
                  name: ""
              },
              categories: [

              ]
          }
      }
  ];

  col1: number[] = [];
  col2: number[] = [];

    @ViewChildren('linkRef') linkRefs;

  constructor(public main: MainService) {
      this.searchParent.valueChanges
          .pipe(debounceTime(400))
          .subscribe(data => {
              this.category.parent = 0;
              this.getSelectCategories({ query: data }).subscribe(response => {
                  if (response && typeof response.data != "undefined") {
                      this.searchResult = response.data;
                  }
              })
          });
  }

  ngOnInit() {
      this.main.breadcrumbs = [
          {
              title: "Kategoriler"
          }
      ];
      this.getCategories();
      this.resetCategory();
  }

  resetCategory() {
      this.category = {
          id: 0,
          name: "",
          description: "",
          parent: 0,
          pathName: ""
      };
  }

    getSelectCategories(params) {
        let response: IResponse = {
            status: 0,
            message: "Aramaya başlamak için bir şeyler yazın!",
            data: []
        };

        if (!params.id && !params.query)
            return of(response);

        return this.main.ajax({
            job: "getSelectCategories",
            data: params
        });
    }

  getCategories(parent: number = 0) {
      this.level = typeof this.levels[parent] != "undefined" ? this.levels[parent] + 1 : 0;
      this.main.ajax({
          job: "getCategories",
          data: {
            parent: parent
          }
      }).subscribe(
          response => {
            if (typeof response != "undefined" && response.status == 1) {
                this.results[this.level] = response;

                if (this.col1.length == 0 && this.col2.length == 0) {
                    this.col1.push(this.level);
                } else {
                    let tempCol1: number[] = [];
                    for (let x in this.col1) {
                        if (this.col1[x] < this.level)
                            tempCol1.push(this.col1[x]);
                    }

                    let tempCol2: number[] = [];
                    for (let y in this.col2) {
                        if (this.col2[y] < this.level)
                            tempCol2.push(this.col2[y]);
                    }

                    this.col1 = tempCol1;
                    this.col2 = tempCol2;

                    let lvl = this.level;
                    let $ = this.main.jQuery;
                    let h1 = 0;
                    $("#column-1").find(".multi-level-list").each(function () {
                        if ($(this).attr("data-cat-level") < lvl)
                            h1 += $(this).height();
                    });

                    let h2 = 0;
                    $("#column-2").find(".multi-level-list").each(function () {
                        if ($(this).attr("data-cat-level") < lvl)
                            h2 += $(this).height();
                    });

                    if (h1 <= h2 && this.col1.indexOf(this.level) == -1)
                        this.col1.push(this.level);
                    else if (h1 > h2 && this.col2.indexOf(this.level) == -1)
                        this.col2.push(this.level);
                }


                if (typeof this.results[this.level].data != "undefined" && typeof this.results[this.level].data.categories != "undefined") {
                    for (let x in this.results[this.level].data.categories) {
                        this.levels[this.results[this.level].data.categories[x].id] = this.level;
                    }
                }
            } else if (typeof response != "undefined") {
                let tempCol1: number[] = [];
                for (let x in this.col1) {
                    if (this.col1[x] < this.level)
                        tempCol1.push(this.col1[x]);
                }

                let tempCol2: number[] = [];
                for (let x in this.col2) {
                    if (this.col2[x] < this.level)
                        tempCol2.push(this.col2[x]);
                }

                this.col1 = tempCol1;
                this.col2 = tempCol2;
                this.main.toastr.error(response.message);
            }
          },
          msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      );
  }

  setParent(parentId: number) {
      this.category.parent = parentId;
      this.category.pathName = "";
      for (let x in this.searchResult.categories) {
          if (this.searchResult.categories[x].id == parentId)
              this.category.pathName = this.searchResult.categories[x].pathName;
      }
  }

  onSubmit(form: any) {
      this.main.ajax({
          job: "createCategory",
          data: form
      }).subscribe(
          response => {
              if (response && response.status == 1) {
                  this.getCategories();
                  this.resetCategory();
                  this.main.toastr.success(response.message);
              } else if (response)
                  this.main.toastr.error(response.message);
          },
          msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      );
  }

    onSelectCat(cid) {
        this.getCategories(cid);
    }

    onEditCat(cid) {
        this.main.ajax({
            job: "getCategory",
            data: {
                id: cid
            }
        }).subscribe(
            response => {
                if (response && response.status == 1)
                    this.category = response.data.category;
            },
            msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
        );
    }

    onDeleteCat(cat: ICategory, confirm: boolean = false) {
        this.delCategory = cat;
        if (!confirm)
            return;

        this.main.ajax({
            job: "deleteCategory",
            data: {
                id: cat.id
            }
        }).subscribe(
            response => {
                if (response && response.status == 1) {
                    this.getCategories();
                    this.resetCategory();
                    this.main.toastr.success(response.message);
                } else if (response)
                    this.main.toastr.error(response.message);
            },
            msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
        );
    }
}

@Component({
    selector: 'categories-list',
    templateUrl: './categories-list.component.html'
})
export class CategoriesListComponent implements OnInit {
  @Input()
  parent: number = 0;

  @Input()
  cl: number = 0;

  @Input()
  delete_swal;

  @Input()
  category_name: string = "";

  @Input()
  categories: any[];

  @Output()
  private onSelect: EventEmitter<number> = new EventEmitter<number>();

  @Output()
  private onEdit: EventEmitter<number> = new EventEmitter<number>();

  @Output()
  private onDelete: EventEmitter<number> = new EventEmitter<number>();

  constructor() { }

  ngOnInit() {
  }

  onSelectClick(cid) {
      this.onSelect.emit(cid);
  }

  onEditClick(cid) {
      this.onEdit.emit(cid);
  }

  onDeleteClick(cat, deleteElement) {
      this.onDelete.emit(cat);
      setTimeout(function () {
          deleteElement.show();
      }, 100);
  }
}
