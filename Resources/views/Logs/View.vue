<script setup>
import {ref} from "vue";
import Container from '@@/Components/Container.vue';
import Header from '@@/Layouts/Includes/Header.vue';
import List from '@@/Layouts/Includes/Table.vue';
import Pagination from '@@/Layouts/Includes/Pagination.vue';
import Filters from '@@/Layouts/Includes/Filters.vue';
import Bulk from '@@/Layouts/Includes/Bulk.vue';
import {Inertia} from '@inertiajs/inertia';
import {buildViewRows} from '@@/Composables/buildViewRows.js';
import {useTrans} from '@@/Composables/useTrans.js';
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
import {useResourceStore} from "@@/Stores/resourceStore.js";

let viewRows = buildViewRows();
const {trans} = useTrans();

const props = defineProps({
    rows: Object,
    collection: Object,
    list: Object,
    roles: Object,
    render: Object,
    errors: Object,
    record: Object,
    url: String,
})

let item = ref(props.record);

function edit(){
    Inertia.visit(route(props.list.url+'.edit', props.record.id));
}
function back(){
    Inertia.visit(route(props.list.url+'.index'));
}

// Check if The Sidebar is expanded or not
const layoutStore = useLayoutStore();
layoutStore.Breadcrumbs = [];

const resourceStore = useResourceStore();
resourceStore.currentUrl = route(props.list.url +'.view', props.record.id);


layoutStore.setBreadcrumbs({
    route: route("dashboard"),
    label: trans('global.dashboard')
});
layoutStore.setBreadcrumbs({
    route: route(props.list.url +".index"),
    label: "Logs"
});
layoutStore.setBreadcrumbs({
    route: route(props.list.url +".view", props.record.id),
    label: "View Log"
});

function viewLog(item){
    Inertia.visit(route(props.list.url +".file", [item.id, props.record.id]));
}
</script>
<template>
    <Container>
        <template #header>
            <Header :title="'View '+ props.record.name ">
                <!-- Actions Generator -->
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
                    :href="route(props.list.url+'.index')"
                >
                    <span class="">
                        Back
                    </span>
                </a>
            </Header>
        </template>
        <template #body>
            <div class="border bg-white dark:bg-gray-800 dark:text-white dark:border-gray-600 rounded-lg">
                <div class="overflow-y-auto relative dark:border-gray-700 border-t">
                    <List
                        :cols="false"
                        :hasBulk="false"
                        :roles="props.roles"
                        :table="props.render.table"
                        :rows="props.rows"
                        :collection="props.collection"
                        :bulk="[]"
                        :url="props.list.url"
                        :desc="props.list.desc"
                        @reload=""
                        @view="viewLog"
                        @edit=""
                        @delete=""
                        @all=""
                        @switch=""
                    >
                        <template #actions="{ id }">
                            <div>
                                <button
                                    @click.prevent=""
                                    style="padding: 5px 8px"
                                    class="filament-link inline-flex items-center justify-center gap-0.5 font-medium hover:underline focus:outline-none focus:underline text-sm text-gray-600 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-200 filament-tables-link-action"
                                    :class="'text-600-primary'"
                                    role="button"
                                >
<!--                                    <i class="text-[16px]" :class="action.icon"></i>-->
<!--                                    <div class="table_tooltip">-->
<!--                                        {{ action.label }}-->
<!--                                    </div>-->
                                </button>
                            </div>
                        </template>
                    </List>
                </div>
                <div class="p-2" :class="{'border-t':Object.keys(props.collection.data).length}" v-show="Object.keys(props.collection.data).length">
                    <Pagination class="px-2" :collection="props.collection"/>
                </div>
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
