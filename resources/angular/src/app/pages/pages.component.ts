import { Component, OnInit } from '@angular/core';
import {PageService} from "../services/page.service";
import {IResponse} from "../interfaces/iresponse";
import {IPageLinks} from "../interfaces/ipage-links";
import {MainService} from "../services/main.service";

@Component({
  selector: 'app-pages',
  templateUrl: './pages.component.html'
})
export class PagesComponent implements OnInit {

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
            this.getPages();
        }
    }

  constructor(public pageService: PageService, public main: MainService) {}

  ngOnInit() {
      this.main.breadcrumbs = [
          {
              title: "Sayfalar"
          }
      ];

      this.getPages();
  }

  getPages() {
      this.main.ajax({
          job: "getPages",
          data: {},
          page: this.page
      }).subscribe(
        response => {
              this.results = response;
              for (let x in this.results.data.pages) {
                  this.results.data.pages[x].status = this.main.getSelectText(this.main.sherlock.page.statuses, this.results.data.pages[x].status);
              }
          },
        msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      );
  }

}
