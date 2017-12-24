import { NgModule }      from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { AppComponent }  from './app.component.ts';
import { HttpModule } from '@angular/http';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { Service } from './request.ts';

@NgModule({
    imports:      [ BrowserModule, HttpModule, FormsModule  ],
    declarations: [ AppComponent ],
    bootstrap:    [ AppComponent ],
    providers: [Service]
})
export class AppModule { }
