<script setup>
import Container from '@@/Components/Container.vue';
import Header from '@@/Layouts/Includes/Header.vue';
import {ref} from "vue";
import {Inertia} from '@inertiajs/inertia';
import {buildEditForm} from '@@/Composables/buildEditForm.js';
import {submitForm} from '@@/Composables/submitForm.js';
import ViltText from '$$/ViltText.vue'
import ViltTel from '$$/ViltTel.vue'
import ViltTextArea from "$$/ViltTextArea.vue";
import ViltNumber from "$$/ViltNumber.vue";
import ViltSelect from "$$/ViltSelect.vue";
import ViltSwitch from "$$/ViltSwitch.vue";
import ViltColor from "$$/ViltColor.vue";
import ViltEmail from "$$/ViltEmail.vue";
import ViltDate from "$$/ViltDate.vue";
import ViltDateTime from "$$/ViltDateTime.vue";
import ViltTime from "$$/ViltTime.vue";
import ViltMedia from "$$/ViltMedia.vue";
import ViltRepeater from "$$/ViltRepeater.vue";
import ViltSchema from "$$/ViltSchema.vue";
import ViltRich from "$$/ViltRich.vue";
import ViltRelation from "$$/ViltRelation.vue";
import ViltHasOne from "$$/ViltHasOne.vue";
import {useLayoutStore} from '@@/Stores/layout.js';
import {useTrans} from '@@/Composables/useTrans.js';

let editRows = buildEditForm();
const {trans} = useTrans();

const props = defineProps({
    rows: Object,
    errors: Object,
    record: Object,
    data: Object,
    url: String,
    file: String
})
let form = ref(props.record);

function save(redirect=false){
    submitForm('.update', form.value, props.record.id, redirect);
}
function back(){
    Inertia.visit(route(props.url+'.index'));
}

// Check if The Sidebar is expanded or not
const layoutStore = useLayoutStore();
layoutStore.Breadcrumbs = [];

layoutStore.setBreadcrumbs({
    route: route("dashboard"),
    label: trans('global.dashboard')
});
layoutStore.setBreadcrumbs({
    route: route(props.url +".index"),
    label: "Logs"
});
layoutStore.setBreadcrumbs({
    route: route(props.url +".view", props.record.id),
    label: "Show Log List"
});
layoutStore.setBreadcrumbs({
    route: route(props.url +".edit", props.record.id),
    label: "Show Log"
});
</script>
<template>
    <Container>
        <template #header>
            <Header :title="'Show Log #'+ props.record.id">
                <a
                    class="
                filament-button
                inline-flex
                items-center
                justify-center
                py-1
                gap-1
                font-medium
                rounded-lg
                border
                transition-colors
                focus:outline-none
                focus:ring-offset-2
                focus:ring-2
                focus:ring-inset
                dark:focus:ring-offset-0
                min-h-[2.25rem]
                px-4
                text-sm
                text-white
                shadow
                focus:ring-white
                border-transparent
                bg-primary-600
                hover:bg-primary-500
                focus:bg-primary-700
                focus:ring-offset-primary-700
                filament-page-button-action"
                    :href="route('logs.view', props.file.id)"
                >
                    <span class="">
                        Back
                    </span>
                </a>
            </Header>
        </template>
        <template #body>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Details
                    </h3>
                </div>
                <div class="border-t border-gray-200 overflow-x-scroll bg-gray-50">
                    <dl>
                        <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Date
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{props.record.date}}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Environment
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{props.record.environment}}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Level
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span
                                    v-if="props.record.level == 'error'"
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            {{props.record.level}}
                                        </span>

                                <span
                                    v-else-if="props.record.level == 'debug'"
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                            {{props.record.level}}
                                        </span>
                                <span
                                    v-else
                                    class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            {{props.record.level}}
                                        </span>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                Context
                            </dt>
                        </div>
                        <div class="bg-gray-50 px-4 pb-5">
                            <dd>
                        <pre
                            class="whitespace-pre-wrap">{{props.record.context}}</pre>
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 pt-5">
                            <dt class="text-sm font-medium text-gray-500">
                                Stack trace
                            </dt>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 w-full">
                            <dd class="mt-1 text-sm text-gray-900" v-if="props.record.stack_traces  && props.record.stack_traces.length">
                                <div
                                    v-for="(item, key) in props.record.stack_traces"
                                    :key="key"
                                    :class="{
                                        'border-b': key===0,
                                        'border-t': key!==props.record.stack_traces.length-1,
                                    }"
                                    class="border-gray-200 py-3">
                                    <div class="grid grid-cols-3 w-full py-0.5 px-1 hover:bg-gray-100 rounded">
                                        <div class="col-span-1 font-bold">Caught at</div>
                                        <div class="col-span-2">{{item.caught_at}}</div>
                                    </div>
                                    <div class="grid grid-cols-3 w-full py-0.5 px-1 hover:bg-gray-100 rounded">
                                        <div class="col-span-1 font-bold">In</div>
                                        <div class="col-span-2">{{item.in}}</div>
                                    </div>
                                    <div class="grid grid-cols-3 w-full py-0.5 px-1 hover:bg-gray-100 rounded">
                                        <div class="col-span-1 font-bold">Line</div>
                                        <div class="col-span-2">{{item.line}}</div>
                                    </div>
                                    <div class="grid grid-cols-3 w-full pt-0.5 px-1 hover:bg-gray-100 rounded">
                                        <div class="col-span-1 font-bold">content</div>
                                        <div class="col-span-2">{{item}}</div>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="py-2 flex justify-start">
                <button class="filament-button inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-page-button-action"
                        @click.prevent="back()">Cancel</button>
            </div>
        </template>
    </Container>
</template>
<script>
import AppLayout from "@@/Layouts/AppLayout.vue";

export default {
    layout: AppLayout,
}
</script>
