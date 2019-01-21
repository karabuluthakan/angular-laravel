import { Component, OnInit } from '@angular/core';
import {PostService} from "../services/post.service";
import {IPost} from "../interfaces/ipost";
import {ICategory} from "../interfaces/icategory";
import {ActivatedRoute} from "@angular/router";
import {MainService} from "../services/main.service";
import {concat, Observable, of, Subject} from "rxjs";
import {catchError, debounceTime, delay, distinctUntilChanged, switchMap, tap} from "rxjs/operators";
import '@ckeditor/ckeditor5-build-classic/build/translations/tr';
import * as ClassicEditor from '@ckeditor/ckeditor5-build-classic';

@Component({
  selector: 'app-create-post',
  templateUrl: './create-post.component.html'
})
export class CreatePostComponent implements OnInit {
    protected id: number = 0;
    public post: IPost = {
        id: 0,
        title: "",
        description: "",
        body: "",
        author_id: "",
        is_sticky: 0,
        status: 1,
        categories: []
    };
    public categories: Observable<ICategory[]>;

    public Editor = ClassicEditor;
    public config = {
        language: "tr",
        height: 600
    };

    category: Observable<ICategory[]>;
    categoryLoading = false;
    categoryInput = new Subject<string>();
    selectedCategories: ICategory[];
    categoryResults: ICategory[] = [];

  constructor(public postService: PostService, public main: MainService, public route: ActivatedRoute) { }

  ngOnInit() {
      this.id = +this.route.snapshot.paramMap.get('id');
      this.main.breadcrumbs = [
          {
              path: "/admin/posts",
              title: "Yazılar"
          }
      ];

      if (this.id > 0) {
          this.main.breadcrumbs[1] = {
              title: "Yazıyı Düzenle"
          };

          this.main.ajax({
              job: "getPost",
              data: {
                  id: this.id
              }
          }).subscribe(
              response => {
                  this.post = response.data.post;
                  this.post.description = this.post.description ? this.post.description : "";
                  this.main.breadcrumbs[1] = {
                      title: this.post.title
                  };
              },
              msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
          );
      } else {
          this.main.breadcrumbs[1] = {
              title: "Yazı Ekle"
          };
      }

      // this.main.ajax({
      //     job: "getSelectCategories",
      //     data: {
      //         query: ""
      //     }
      // }).subscribe(
      //     response => {
      //         this.categories = response.data.categories;
      //     },
      //     msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      // );

      this.getSelectedCategories();
      this.loadCategory();
  }

  formReset() {
      this.post = {
          id: 0,
          title: "",
          description: "",
          body: "",
          author_id: "",
          is_sticky: 0,
          status: 1,
          categories: []
      };
  }

  onSubmit(form: any) {
      form.author_id = this.post.author_id;
      form.categories = this.post.categories;
      form.description = this.post.description;
      form.body = this.post.body;
      this.main.ajax({
          job: "createPost",
          data: form
      }).subscribe(
          response => {
              if (response.status == 1) {
                  if (this.id <= 0)
                    this.formReset();

                  this.main.toastr.success(response.message);
              } else
                this.main.toastr.error(response.message);
          },
          msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      );
  }

  // getSelectCategories
    private loadCategory() {
        this.category = concat(
            of([]), // default items
            this.categoryInput.pipe(
                debounceTime(200),
                distinctUntilChanged(),
                tap(() => this.categoryLoading = true),
                switchMap(term => this.getCategory(term).pipe(
                    catchError(() => of([])), // empty list on error
                    tap(() => this.categoryLoading = false)
                ))
            )
        );
    }

    getSelectedCategories() {
        if (this.post.categories.length == 0)
            return;

        this.main.ajax({
            job: "getSelectCategories",
            data: {ids: this.post.categories}
        }).subscribe(
            response => {
                this.category = typeof response.data != "undefined" ? response.data.categories : [];
            },
            msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
        );
    }

    getCategory(term: string = null): Observable<ICategory[]> {
      if (term) {
          this.main.ajax({
              job: "getSelectCategories",
              data: {query: term}
          }).subscribe(
              response => {
                  this.categoryResults = typeof response.data != "undefined" ? response.data.categories : [];
              },
              msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
          );
      }

        return of(this.categoryResults).pipe();
    }
}
