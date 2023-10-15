<template>
    <div>
        <SideMenu @changeTab="changeTab"/>
        <Dashboard v-if="currentTab === 'dashboard'"/>
        <RawData v-if="currentTab === 'rawData'"/>
    </div>
</template>

<script>
import SideMenu from './SideMenu.vue'
import Dashboard from './Dashboard.vue'
import RawData from './RawData.vue'

export default {
    components: {
        SideMenu,
        Dashboard,
        RawData
    },
    data() {
        return {
            currentTab: 'dashboard'
        }
    },
    methods: {
        changeTab(tab) {
            this.currentTab = tab;
        }
    }
}
</script>
