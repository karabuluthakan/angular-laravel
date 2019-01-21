import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {DashboardComponent} from "./dashboard/dashboard.component";
import {CreatePostComponent} from "./create-post/create-post.component";
import {PostsComponent} from "./posts/posts.component";
import {PagesComponent} from "./pages/pages.component";
import {CreatePageComponent} from "./create-page/create-page.component";
import {UsersComponent} from "./users/users.component";
import {CreateUserComponent} from "./create-user/create-user.component";
import {CategoriesComponent} from "./categories/categories.component";
import {RolesComponent} from "./roles/roles.component";
import {RolesPermsComponent} from "./roles-perms/roles-perms.component";

const routes: Routes = [
    {
        path: 'admin',
        component: DashboardComponent
    },
    {
        path: 'admin/posts/create',
        component: CreatePostComponent
    },
    {
        path: 'admin/posts/:id/edit',
        component: CreatePostComponent
    },
    {
        path: 'admin/posts',
        component: PostsComponent
    },
    {
        path: 'admin/categories',
        component: CategoriesComponent
    },
    {
        path: 'admin/pages/create',
        component: CreatePageComponent
    },
    {
        path: 'admin/pages/:id/edit',
        component: CreatePageComponent
    },
    {
        path: 'admin/pages',
        component: PagesComponent
    },
    {
        path: 'admin/users',
        component: UsersComponent
    },
    {
        path: 'admin/users/create',
        component: CreateUserComponent
    },
    {
        path: 'admin/users/:id/edit',
        component: CreateUserComponent
    },
    {
        path: 'admin/roles',
        component: RolesComponent
    },
    {
        path: 'admin/roles/perms',
        component: RolesPermsComponent
    }
];

@NgModule({
    imports: [ RouterModule.forRoot(routes) ],
    exports: [ RouterModule ]
})
export class AppRoutingModule { }
