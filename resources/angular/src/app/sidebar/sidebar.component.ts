import { Component, OnInit } from '@angular/core';
import {MainService} from "../services/main.service";
import {IResponse} from "../interfaces/iresponse";

@Component({
  selector: 'app-sidebar',
  templateUrl: './sidebar.component.html'
})
export class SidebarComponent implements OnInit {

    public results: IResponse = {
        status: 0,
        data: {
            links: [

            ]
        }
    };

  constructor(public main: MainService) { }

  ngOnInit() {
    this.getMenuLinks();
  }

  getMenuLinks() {
      this.main.ajax({
          job: "getMenuLinks",
          data: {
              position: "admin_leftsidebar_menu"
          }
      }).subscribe(
          response => {
              this.results = response;
              // for (let x in this.results.data.links) {
              //   this.results.data.links[x].expand = false;
              // }
          },
          msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      );
  }

  filterLinks(links, parent = null) {
      let _links = [];
      for (let x in links) {
          if (links[x].parent == parent)
            _links.push(links[x]);
      }

      return _links;
  }

  getLinkClass(link) {
      if (link.type == 2)
        return "m-menu__section m-menu__section--first";

      let cls = "m-menu__item";
      if (link.has_child)
        cls += " m-menu__item--submenu";

      if (link.is_active)
        cls += " m-menu__item--active";

      if (link.expand)
        cls += " m-menu__item--open";

      if (link.is_child_active)
        cls += " m-menu__item--expanded";

      return cls;
  }

    expandSubLinks(link) {
        if (typeof link.expand == "undefined")
          link.expand = true;
        else
          link.expand = !link.expand;
    }
}
