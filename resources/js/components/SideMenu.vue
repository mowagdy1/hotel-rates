<template>
    <nav class="side-menu">
        <button
            @click="changeTab('dashboard')"
            class="btn side-menu-btn"
            :class="{ 'active': currentTab === 'dashboard' }"
        >
            Dashboard
        </button>
        <button
            @click="changeTab('rawData')"
            class="btn side-menu-btn"
            :class="{ 'active': currentTab === 'rawData' }"
        >
            Raw Data
        </button>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            currentTab: 'dashboard'
        }
    },
    methods: {
        changeTab(tab) {
            this.currentTab = tab;
            this.$emit('changeTab', tab);
        }
    }
}
</script>

<style scoped>
.side-menu {
    display: flex;
    justify-content: start;
    background-color: white;
    padding: 10px 20px;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
}

.btn {
    font-family: Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    font-weight: 400;
    font-size: 16px;
    line-height: 1.25;
    box-sizing: border-box;
    height: 40px;
    padding: 5px 10px;
    background-color: white;
    color: #0b0c0c;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
    border: none;
    margin-right: 10px;
    transition: all 0.3s ease;
}

.btn:hover {
    background-color: #f5f5f5;
}

.btn.active {
    border-bottom: 2px solid #0b0c0c;
    background-color: #f0f0f0;
}

@media only screen and (min-width: 40rem) {
    .btn {
        font-size: 19px;
        line-height: 1.31579;
    }
}
</style>
