import { Component, OnInit } from '@angular/core';
import {MainService} from "../services/main.service";
import {IResponse} from "../interfaces/iresponse";

@Component({
  selector: 'app-roles-perms',
  templateUrl: './roles-perms.component.html'
})
export class RolesPermsComponent implements OnInit {

  public path: string = "rolesPerms";
  public roles: object = {};
  public results: IResponse = {
      status: 0,
      data: {
          perms: [

          ]
      }
  };

    private _selecRoles: object;
    get selecRoles(): object {
        if (!this._selecRoles)
            this._selecRoles = JSON.parse(JSON.stringify(this.roles));

        return this._selecRoles;
    }

    set selecRoles(value: object) {
        this._selecRoles = value;
    }

    private _activeRoles: string[] = null;
    get activeRoles(): string[] {
        if (this._activeRoles == null && Object.keys(this.roles).length > 0) {
            this._activeRoles = [];
            for (let id in this.roles) {
                if (this.roles[id].active == 1)
                    this._activeRoles.push(id);
            }
        }

        return this._activeRoles;
    }

    set activeRoles(value: string[]) {
        this._activeRoles = value;
    }

  constructor(public main: MainService) { }

  ngOnInit() {
    this.getRoles();
  }

  getRoles() {
    this.main.ajax({
        job: "getRoles",
        data: {},
        sorting: {
            name: "asc"
        },
        page: -1
    }).subscribe(
        response => {
            if (response && response.status == 1) {
                for(let x in response.data.roles) {
                    this.roles[response.data.roles[x].id] = {
                        slug: response.data.roles[x].slug,
                        name: response.data.roles[x].name,
                        active: Number(x) < 5 ? 1 : 0
                    };
                }

                this.getRolePerms();
            }
        },
        msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
    );
  }

  _getRolesIds() {
      let rolesIds = [];
      for (let x in this.roles) {
          rolesIds.push(x);
      }

      return rolesIds;
  }

    getRolePerms() {
        this.main.ajax({
            job: "getRolePerms",
            data: {
                roles: this.activeRoles
            },
            page: -1
        }).subscribe(
            response => {
                this.results = response;
                this.main.jQuery("#selectRolesModal").modal("hide");
                this.main.stopLoader();
            },
            msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
        );
    }

    setActiveRoles() {
        this.roles = JSON.parse(JSON.stringify(this._selecRoles));
        this.activeRoles = null;
        this.getRolePerms();
    }

    setRolePerm(role_id, name, can_do) {
        this.main.startLoader();
        this.main.ajax({
            job: "setRolePerm",
            data: {
                role_id: role_id,
                name: name,
                can_do: can_do
            },
            page: -1
        }).subscribe(
            response => {
                if (response && response.status == 1)
                    this.main.toastr.success(response.message);
                else
                    this.main.toastr.error(response.message);

                this.getRolePerms();
            },
            msg => {
                this.main.stopLoader();
                console.error(`Error: ${msg.status} ${msg.statusText}`);
            }
        );
    }

}
