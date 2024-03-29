/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

require('./playlist')

import ClipboardJS from 'clipboard'

window.Vue = require('vue')

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//const files = require.context('./', true, /\.vue$/i);
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('main-viewer', require('./components/MainViewer.vue').default)

$(() => {
    var clipboard = new ClipboardJS('.copy-playlist-url-btn');
    clipboard.on('success', function(e) {
        var el = $(e.trigger);

        $(el).tooltip({
            title: 'Link copied!'
        });

        $(el).tooltip('show');

        setTimeout(function() {$(el).tooltip('dispose');}, 2000);
    })
})
