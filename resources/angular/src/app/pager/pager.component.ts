import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';

@Component({
  selector: 'pager',
  templateUrl: './pager.component.html'
})
export class PagerComponent implements OnInit {
  @Input()
  total: number;

  @Input()
  per_page: number;

  @Input()
  current_page: number;

  @Input()
  last_page: number;

  @Input()
  pages: number[];

  @Output()
  private changePage: EventEmitter<number> = new EventEmitter<number>();

  constructor() { }

  ngOnInit() {
  }

  setPage(page) {
    if (page > this.last_page || page < 1)
      return;

    this.changePage.emit(this.current_page = page);
  }

}
