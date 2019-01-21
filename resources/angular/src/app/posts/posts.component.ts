import { Component, OnInit } from '@angular/core';
import {PostService} from "../services/post.service";
import {IResponse} from "../interfaces/iresponse";
import {IPageLinks} from "../interfaces/ipage-links";
import {MainService} from "../services/main.service";

@Component({
  selector: 'app-posts',
  templateUrl: './posts.component.html'
})
export class PostsComponent implements OnInit {

    protected _page: number = 1;
    public results: IResponse = {
        status: 0,
        data: {
          posts: [

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
            this.getPosts();
        }
    }

  constructor(public postService: PostService, public main: MainService) {}

  ngOnInit() {
      this.main.breadcrumbs = [
          {
              title: "Yazılar"
          }
      ];

      this.getPosts();
  }

  getPosts() {
      this.main.ajax({
          job: "getPosts",
          data: {},
          page: this.page
      }).subscribe(
        response => {
              this.results = response;
              if (typeof this.results.data != "undefined") {
                  for (let x in this.results.data.posts) {
                      this.results.data.posts[x].author = this.main.getSelectText(this.main.sherlock.users, this.results.data.posts[x].author_id);
                      this.results.data.posts[x].status = this.main.getSelectText(this.main.sherlock.post.statuses, this.results.data.posts[x].status);
                  }
              }
          },
        msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      );
  }
}
