/**
 * Text field input component for Bootstrap.
 */
Vue.component('ts-text', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="text" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

/**
 * Date field input component for Bootstrap.
 */
Vue.component('ts-date', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="date" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});


/**
 * E-mail field input component for Bootstrap.
 */
Vue.component('ts-email', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="email" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});


/**
 * Password field input component for Bootstrap.
 */
Vue.component('ts-password', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="password" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});

/**
 * Checkbox field input component for Bootstrap.
 */
Vue.component('ts-checkbox', {
    props: ['display', 'form', 'name', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-9">\
        <input type="checkbox" class="form-control" v-model="input">\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});


/**
 * Select input component for Bootstrap.
 */
Vue.component('ts-select', {
    props: ['display', 'form', 'name', 'items', 'input', 'show'],

    template: '<div v-show="typeof show !== \'undefined\' ? show : true" class="form-group" :class="{\'has-error\': form.errors.has(name)}">\
    <label class="col-md-3 control-label">{{ display }}</label>\
    <div class="col-md-8">\
        <select class="form-control" v-model="input">\
            <option v-for="item in items" :value="item.value">\
                {{ item.text }}\
            </option>\
        </select>\
        <span class="help-block" v-show="form.errors.has(name)">\
            <strong>{{ form.errors.get(name) }}</strong>\
        </span>\
    </div>\
</div>'
});
