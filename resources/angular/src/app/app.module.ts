import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import { NgSelectModule } from '@ng-select/ng-select';
import { HttpClientModule } from '@angular/common/http';

import { AppComponent } from './app.component';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { SidebarComponent } from './sidebar/sidebar.component';
import { SubheaderComponent } from './subheader/subheader.component';
import { AppRoutingModule } from './app-routing.module';
import { DashboardComponent } from './dashboard/dashboard.component';
import { CreatePostComponent } from './create-post/create-post.component';
import { PostsComponent } from './posts/posts.component';
import {PagerComponent} from "./pager/pager.component";
import {PagesComponent} from "./pages/pages.component";
import {CreatePageComponent} from "./create-page/create-page.component";
import { CKEditorModule } from '@ckeditor/ckeditor5-angular';
import { UsersComponent } from './users/users.component';
import {CreateUserComponent} from "./create-user/create-user.component";
import {FileUploadModule} from "ng2-file-upload";
import { CategoriesComponent, CategoriesListComponent } from './categories/categories.component';
import { SweetAlert2Module } from '@toverux/ngx-sweetalert2';
import { RolesComponent } from './roles/roles.component';
import { RolesPermsComponent } from './roles-perms/roles-perms.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    SidebarComponent,
    PagerComponent,
    SubheaderComponent,
    DashboardComponent,
    CreatePostComponent,
    PostsComponent,
    CreatePageComponent,
    PagesComponent,
    UsersComponent,
    CreateUserComponent,
    CategoriesComponent,
    CategoriesListComponent,
    RolesComponent,
    RolesPermsComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    ReactiveFormsModule,
    HttpClientModule,
    AppRoutingModule,
    NgSelectModule,
    CKEditorModule,
    FileUploadModule,
    SweetAlert2Module.forRoot({
      buttonsStyling: false,
      customClass: 'modal-content',
      confirmButtonClass: 'btn btn-primary',
      cancelButtonClass: 'btn'
    })
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
