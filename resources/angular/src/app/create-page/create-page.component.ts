import { Component, OnInit } from '@angular/core';
import {PageService} from "../services/page.service";
import {IPage} from "../interfaces/ipage";
import {ActivatedRoute} from "@angular/router";
import {MainService} from "../services/main.service";

@Component({
  selector: 'app-create-page',
  templateUrl: './create-page.component.html'
})
export class CreatePageComponent implements OnInit {
    protected id: number = 0;
  public page: IPage = {
    id: 0,
    title: "",
    description: "",
    body: "",
    parent: 0,
    status: 1
  };

  constructor(public pageService: PageService, public main: MainService, public route: ActivatedRoute) { }

  ngOnInit() {
      this.id = +this.route.snapshot.paramMap.get('id');
      this.main.breadcrumbs = [
          {
              path: "/admin/pages",
              title: "Sayfalar"
          }
      ];

      if (this.id > 0) {
          this.main.breadcrumbs[1] = {
              title: "Sayfayı Düzenle"
          };

          this.main.ajax({
              job: "getPage",
              data: {
                  id: this.id
              }
          }).subscribe(
              response => {
                  this.page = response.data.page;
                  this.main.breadcrumbs[1] = {
                      title: this.page.title
                  };
              },
              msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
          );
      } else {
          this.main.breadcrumbs[1] = {
              title: "Sayfa Ekle"
          };
      }
  }

  formReset() {
      this.page = {
          id: 0,
          title: "",
          description: "",
          body: "",
          parent: 0,
          status: 1
      };
  }

  onSubmit(form: any) {
      this.main.ajax({
          job: "createPage",
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

}
