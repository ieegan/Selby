@extends('dashboard.layouts.app')
@section('title','Dashboard')
@section('content')
<section class="section">
    <div class="container">
        <v-select label="code" v-model="selected" @change="onChange($event)" :filterable="false" :options="options" @search="onSearch">
            <template slot="no-options">
                type to search products
            </template>
            <template slot="option" slot-scope="option">
                <div v-text="option.code"></div>
                <div v-text="option.description"></div>
                <div class="price" v-text="option.price"></div>
            </template>
            <template slot="selected-option" slot-scope="option">
                <div v-text="option.code"></div>
            </template>
        </v-select>
        <div class="detailed" v-if="selected">
            <h2 class="subtitle is-6" v-text="selected.description"></h2>
            <div class="level is-mobile">
                <div class="level-left">
                    <div class="level-item" v-text="selected.code"></div>
                </div>
                <div class="level-right">
                    <div class="level-item price" v-text="selected.price"></div>
                </div>
            </div>
            @hasanyrole('admin|supervisor')
            <div class="level is-mobile" v-for="stock in stocks">
                <div class="level-left">
                    <div class="level-item" v-text="stock.location.name"></div>
                </div>
                <div class="level-right">
                    <div class="level-item" v-text="stock.quantity"></div>
                </div>
            </div>
            @endhasanyrole
            <div class="level is-mobile">
                <div class="level-left">
                    <div class="level-item">Total</div>
                </div>
                <div class="level-right">
                    <div class="level-item" v-text="selected.onhand"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
