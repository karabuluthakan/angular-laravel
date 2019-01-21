import { Component, OnInit } from '@angular/core';
import {IRole} from "../interfaces/irole";
import {MainService} from "../services/main.service";
import {IResponse} from "../interfaces/iresponse";
import {IPageLinks} from "../interfaces/ipage-links";

@Component({
  selector: 'app-roles',
  templateUrl: './roles.component.html'
})
export class RolesComponent implements OnInit {
  role: IRole = {
      id: 0,
      name: "",
      slug: "",
      status: 1,
      statusText: ""
  };
    protected _page: number = 1;
    public results: IResponse = {
        status: 0,
        data: {
            roles: [

            ]
        },
        pageLinks: <IPageLinks>{}
    };
    public get page(): number {
        return this._page;
    }
    public set page(val: number) {
        if (val !== this.page) {
            this._page = val;
            this.getRoles();
        }
    }
    public path: string = "roles";

  constructor(public main: MainService) { }

  ngOnInit() {
      this.main.breadcrumbs = [
          {
              title: "Roller"
          }
      ];

      this.getRoles();
  }

  onSubmit(form: any) {
      this.main.ajax({
          job: "createRole",
          data: form
      }).subscribe(
          response => {
              if (response.status == 1) {
                  this.formReset();
                  this.getRoles();
                  this.main.toastr.success(response.message);
              } else
                  this.main.toastr.error(response.message);
          },
          msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      );
  }

  onClick(id: number) {
      for (let x in this.results.data.roles) {
          if (this.results.data.roles[x].id == id)
            this.role = Object.assign([], this.results.data.roles[x]);
      }
  }

    getRoles() {
        this.main.ajax({
            job: "getRoles",
            data: {},
            page: this.page
        }).subscribe(
            response => {
                this.results = response;
                if (typeof this.results.data != "undefined") {
                    for (let x in this.results.data.roles) {
                        this.results.data.roles[x].statusText = this.main.getSelectText(this.main.sherlock.roles.statuses, this.results.data.roles[x].status);
                    }
                }
            },
            msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
        );
    }

    formReset() {
        this.role = {
            id: 0,
            name: "",
            slug: "",
            status: 1,
            statusText: ""
        };
    }
}
