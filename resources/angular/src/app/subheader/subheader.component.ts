import { Component, OnInit } from '@angular/core';
import {MainService} from "../services/main.service";

@Component({
  selector: 'app-subheader',
  templateUrl: './subheader.component.html'
})
export class SubheaderComponent implements OnInit {

  constructor(public main: MainService) { }

  ngOnInit() {
  }

}
