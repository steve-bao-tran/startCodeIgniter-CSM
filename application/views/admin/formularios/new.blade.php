@extends('admin.layouts.app')

@section('title', $title)

@section('header')
@include('admin.shared.header')
@endsection

@section('content')
<div class="container" id="formModule">
    <div class="col s12 center" v-bind:class="{ hide: !loader }">
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue-only">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div><div class="gap-patch">
                <div class="circle"></div>
              </div><div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>
          </div>
    </div>
    <div v-cloak v-if="!loader">
        <div class="row">
            <div class="col s12">
                <div class="input-field col s12">
                    <input placeholder="Form Name" v-model="form_name" id="form_name" type="text" class="validate">
                    <label for="form_name" class="active">Form Name</label>
                </div>
            </div>
            <div class="col s9">
                <div class="row">
                    <div class="col s12">
                        <ul class="vtabs">
                            <li class="vtab col s3" v-for="(tab, index) in tabs" :id="index" :class="{active : tab.active}">
                                <a :href="'#' + tab.tabID" @click="setActive(index)" v-if="!tab.edited">@{{tab.name}}</a>
                                <i class="material-icons right" v-if="!tab.edited && index != 0"
                                    @click="deleteTab(index)">delete</i>
                                <input type="text" :id="'input' + index" v-model="tab.name"
                                    v-on:keyup.enter="saveTab(index)" v-on:blur="saveTab(index)" v-if="tab.edited">
                            </li>
                            <li class="vtab col s3"><a href="#tab1" @click="addTab()">New Tab +</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col s12 tab-pane" v-for="(tab, i) in tabs" :id="tab.tabID" :class="{active : tab.active}">
                    <div id="simple-list">
                        <div class="row" v-for="(field, index) in tab.fields">
                            <div class="col s12 component">
                                <component 
                                    :serve-data="field.serveData"
                                    :is="field.component" 
                                    :tab-parent="tab" 
                                    :field-ref-index="index"
                                    :field-ref="field" 
                                    ref="field.component"
                                    >
                                </component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s3 formsElements">
                <div class="row">
                    <div class="col s12">
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>Campos</h5>
                            </li>
                            <li class="collection-item" v-for="(formsElement, index) in formsElements">
                                <div>@{{formsElement.displayName}}
                                    <a href="#!" class="secondary-content" @click="addField(formsElement)"><i
                                            class="material-icons">@{{formsElement.icon}}</i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                Activar Formulario
                <div class="switch">
                    <label>
                        No activo
                        <input type="checkbox" checked v-model="form_status" name="status" value="on">
                        <span class="lever"></span>
                        Activo
                    </label>
                </div>
            </div>
            <br>
            <div class="col s12 text-center form-group" class="" id="buttons">
                <a href="<?php echo base_url('admin/formularios/'); ?>" class="btn red darken-1">Cancelar</a>
                <a class="waves-effect waves-light btn" @click="saveData()"><i class="material-icons right">cloud</i> Guardar</a>
            </div>
        </div>
    </div>
</div>
<script type="text/x-template" id="formFieldTitle-template">
    <div class="row formFieldTitle">
        <div class="col s12">
            <b>Field Preview:</b>
        </div>
        <div class="input-field col s12"> 
            <input :placeholder="fieldPlaceholder" v-model="fieldName" @keyup="convertfielApiID()" :id="fieldID" type="text" class="validate">
            <label :for="fieldID" class="active">@{{fieldName}}</label>
        </div>
        <div class="col s12">
            <ul class="collapsible">
                <li>
                  <div class="collapsible-header"><i class="material-icons">settings</i>Config</div>
                  <div class="collapsible-body">
                    <div class="row">
                        <div class="input-field col s12">
                            Field Name
                            <br />
                            <input placeholder="Field Name" @keyup="convertfielApiID()" v-model="fieldName" type="text" class="validate">
                        </div>
                        <div class="input-field col s12">
                            Api ID
                            <input placeholder="Api ID" v-model="fielApiID" type="text" class="validate">
                        </div>
                        <div class="input-field col s12">
                            Placeholder
                            <input placeholder="Field Placeholder" v-model="fieldPlaceholder" type="text" class="validate">
                        </div>
                    </div>
                  </div>
                </li>
              </ul>
        </div>
    </div>
</script>
@isset($form_id)
    <script>
        const form_id = <?= $form_id; ?>;
    </script>
@endisset
@endsection