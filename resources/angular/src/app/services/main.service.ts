import { Injectable } from '@angular/core';
import {IRequest} from "../interfaces/irequest";
import {IResponse} from "../interfaces/iresponse";
import {HttpClient, HttpHeaders} from "@angular/common/http";
import {Router} from "@angular/router";
declare var sherlock: any;
declare var jQuery: any;
declare var toastr: any;

const httpOptions = {
    headers: new HttpHeaders({ 'Content-Type': 'application/json; charset=utf-8' })
};

@Injectable({
  providedIn: 'root'
})
export class MainService {
    public sherlock;
    public jQuery;
    public toastr;
    public breadcrumbs: object[];
    private _title = "";
    get title() {
        if (this.breadcrumbs.length > 0)
            this._title = this.breadcrumbs[this.breadcrumbs.length - 1]["_title"];

        return this._title;
    }

    protected body;

    constructor(private http: HttpClient) {
        this.sherlock = sherlock;
        this.jQuery = jQuery;
        this.toastr = toastr;
        this.body = document.getElementsByTagName('body')[0];
    }

    startLoader() {
        this.body.classList.add('sloading');
    }

    stopLoader() {
        this.body.classList.remove('sloading');
    }

    ajax(request: IRequest) {
        request._token = this.sherlock.token;
        return this.http
            .post<IResponse>(this.sherlock.ajax_url, JSON.stringify(request), httpOptions);
    }

    getSelectText(selectList, selected) {
        for (let x in selectList) {
            if (selectList[x].value == selected)
                return selectList[x].label;
        }

        return '';
    }
}
