import {Component, NgModule, NgZone} from '@angular/core'
import {BrowserModule} from '@angular/platform-browser'
import {Service} from './request.ts'

@Component({
    selector: 'my-app',
    templateUrl: '/js/app/app.component.html',
})
export class AppComponent {

    constructor(private service: Service) {

    }

    responseResult;
    products: Products[];
    keys: String[];

    ngOnInit() {
        this.service.getProducts()
            .subscribe(data => {
                    this.responseResult = data;
                    this.products = this.responseResult.data;
                    this.keys = Object.keys(this.products);
                    console.log(this.responseResult);
                },
                error => {
                    console.log(error)
                });
    }
}

