import { Injectable } from '@angular/core';
import { Http, RequestOptionsArgs, Response, Headers, RequestOptions } from '@angular/http';
import { Observable, BehaviorSubject } from 'rxjs';
import 'rxjs/add/operator/map';
import 'rxjs/add/operator/toPromise';

@Injectable()
export class Service {

    private searchUrl: string;

    constructor(private _http: Http) { }

    getProducts() {
        this.searchUrl = `http://zend.com/album`;

        return this._http.get(this.searchUrl)
            .map((res) => { return res.json() })

    }
}