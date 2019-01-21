import { Component, OnInit } from '@angular/core';
import {UserService} from "../services/user.service";
import {ActivatedRoute} from "@angular/router";
import {MainService} from "../services/main.service";
import {IUser} from "../interfaces/iuser";
import {FileUploader} from "ng2-file-upload";
declare var sherlock: any;

@Component({
  selector: 'app-create-user',
  templateUrl: './create-user.component.html'
})
export class CreateUserComponent implements OnInit {
    protected id: number = 0;
    public user: IUser = {
        id: 0,
        username: "",
        firstname: "",
        lastname: "",
        email: "",
        role_id: 0,
        avatar: "",
        created_at: "",
        password: "",
        password_confirmation: "",
        status: 1
    };
    imageUrl: string = "http://personalsite.test/images/hk.jpg";
    fileToUpload: File = null;

    public uploader: FileUploader = new FileUploader({
        url: sherlock.ajax_url,
        itemAlias: 'data[avatar]',
        additionalParameter: {
            _token: sherlock.token,
            job: "createUser"
        },
    });

    constructor(public userService: UserService, public main: MainService, public route: ActivatedRoute) { }

  ngOnInit() {
      this.id = +this.route.snapshot.paramMap.get('id');
      this.main.breadcrumbs = [
          {
              path: "/admin/users",
              title: "Kullanıcılar"
          }
      ];

      if (this.id > 0) {
          this.main.breadcrumbs[1] = {
              title: "Kullanıcıyı Düzenle"
          };

          this.main.ajax({
              job: "getUser",
              data: {
                  id: this.id
              }
          }).subscribe(
              response => {
                  this.user = response.data.user;
                  this.main.breadcrumbs[1] = {
                      title: this.user.firstname + " " + this.user.lastname
                  };
                  this.user.password = "";
                  this.user.password_confirmation = "";
              },
              msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
          );
      } else {
          this.main.breadcrumbs[1] = {
              title: "Kullanıcı Ekle"
          };
      }

      this.uploader.onAfterAddingFile = (file) => {
          file.withCredentials = false;
      };
      this.uploader.onCompleteItem = (item: any, response: any, status: any, headers: any) => {
          console.log('ImageUpload:uploaded:', item, status, response);
          alert('File uploaded successfully');
      };
  }

  formReset() {
      this.user = {
          id: 0,
          username: "",
          firstname: "",
          lastname: "",
          email: "",
          role_id: 0,
          avatar: "",
          created_at: "",
          password: "",
          password_confirmation: "",
          status: 1
      };
  }

  onSubmit() {
      // this.user._avatar = this.fileToUpload;
      //
      // const formData: FormData = new FormData();
      // formData.append('Image', this.fileToUpload, this.fileToUpload.name);

      for (let x in this.user) {
          this.uploader.options.additionalParameter["data[" + x + "]"] = this.user[x];
      }

      this.uploader.uploadAll()

      // this.main.ajax({
      //     job: "createUser",
      //     data: formData
      // }).subscribe(
      //     response => {
      //         if (response.status == 1) {
      //             if (this.id <= 0)
      //               this.formReset();
      //
      //             this.main.toastr.success(response.message);
      //         } else
      //           this.main.toastr.error(response.message);
      //     },
      //     msg => console.error(`Error: ${msg.status} ${msg.statusText}`)
      // );
  }

  // getSelectCategories

    handleFileInput(file: FileList) {
        this.fileToUpload = file.item(0);

        //Show image preview
        var reader = new FileReader();
        reader.onload = (event:any) => {
            this.imageUrl = event.target.result;
        }
        reader.readAsDataURL(this.fileToUpload);
    }

}
