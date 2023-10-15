<template>
    <div class="raw-data">
        <div class="input-wrapper">
            <input type="date" v-model="queryDate" class="input-date">
            <button @click="resetDate" class="btn">Reset date</button>
            <button @click="getRawData" class="btn main-btn">Get Raw Data</button>
        </div>
        <table class="data-table">
            <thead>
            <tr>
                <th>Hotel Name</th>
                <th>Date Scraped</th>
                <th>Date of Stay</th>
                <th>Rate per Night</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in rawData" :key="item.id" class="data-row">
                <td>{{ item.hotel.name }}</td>
                <td>{{ item.date_scraped }}</td>
                <td>{{ item.date_of_stay }}</td>
                <td>{{ item.rate_per_night }}</td>
            </tr>
            </tbody>
        </table>
        <div class="btn-wrapper">
            <button @click="prevPage" class="btn">Previous</button>
            <button @click="nextPage" class="btn">Next</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            queryDate: null,
            currentPage: 1,
            rawData: []
        }
    },
    watch: {
        queryDate() {
            this.currentPage = 1;
        }
    },
    methods: {
        async getRawData() {
            try {
                let api = '/api/rates'
                if (this.queryDate == null) {
                    api += `?page=${this.currentPage}`
                } else {
                    api += `?date=${this.queryDate}&page=${this.currentPage}`
                }
                const response = await axios.get(api);
                this.rawData = response.data.data;
            } catch (error) {
                console.error(error);
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.getRawData();
            }
        },
        nextPage() {
            this.currentPage++;
            this.getRawData();
        },
        resetDate() {
            this.queryDate = null;
        }
    }
}
</script>

<style scoped>
.raw-data {
    font-family: Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    font-weight: 400;
    font-size: 16px;
    line-height: 1.25;
    display: block;
    position: relative;
    min-height: 40px;
    margin-bottom: 10px;
    padding-left: 40px;
    clear: left;
}

.input-wrapper,
.btn-wrapper {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.input-date,
.btn {
    font-family: Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    font-weight: 400;
    font-size: 16px;
    line-height: 1.25;
    box-sizing: border-box;
    width: 100%;
    height: 40px;
    margin-top: 0;
    padding: 5px;
    border: 2px solid #0b0c0c;
    border-radius: 0;
    appearance: none;
}

.main-btn {
    background-color: black;
    color: white;
    margin-left: 10px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
}

.data-table th,
.data-table td {
    border: 1px solid #0b0c0c;
    padding: 10px;
    text-align: left;
}

.data-row {
    transition: background-color 0.3s ease;
}

.data-row:hover {
    background-color: #f5f5f5;
}

@media only screen and (min-width: 40rem) {
    .raw-data,
    .input-date,
    .btn {
        font-size: 19px;
        line-height: 1.31579;
    }
}
</style>
