import { Component, OnInit } from '@angular/core';
import {PageService} from "../services/page.service";
import {IResponse} from "../interfaces/iresponse";
import {IPageLinks} from "../interfaces/ipage-links";
import {MainService} from "../services/main.service";

@Component({
  selector: 'app-users',
  templateUrl: './users.component.html'
})
export class UsersComponent implements OnInit {

    protected _page: number = 1;
    public results: IResponse = {
        status: 0,
        data: {
          pages: [

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
            this.getUsers();
        }
    }

  constructor(public pageService: PageService, public main: MainService) {}

  ngOnInit() {
      this.main.breadcrumbs = [
          {
              title: "Kullanıcılar"
          }
      ];

      this.getUsers();
  }

  getUsers() {
      this.main.ajax({
          job: "getUsers",
          data: {},
          page: this.page
      }).subscribe(
        response => {
              this.results = response;
              for (let x in this.results.data.users) {
                  this.results.data.users[x].status = this.main.getSelectText(this.main.sherlock.user.statuses, this.results.data.users[x].status);
              }
          },
        msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      );
  }

}
