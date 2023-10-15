<template>
    <div class="dashboard">
        <div class="input-wrapper">
            <input type="date" v-model="startDate" class="input-date">

            <select v-model="selectedHotel" class="input-date">
                <option disabled value="">Please select a hotel</option>
                <option v-for="hotel in hotels" :key="hotel.id" :value="hotel.id">{{ hotel.name }}</option>
            </select>

            <button @click="getRates" class="btn main-btn">Get Rates</button>
        </div>
        <div v-if="error" class="error">{{ error }}</div>
        <div>
            <canvas id="myChart"></canvas>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {Chart, LineController, LinearScale, CategoryScale, PointElement, LineElement} from 'chart.js';

Chart.register(LineController, LinearScale, CategoryScale, PointElement, LineElement);

export default {
    data() {
        return {
            startDate: null,
            chart: null,
            hotels: [],
            selectedHotel: '',
            error: ''
        }
    },
    async created() {
        try {
            const response = await axios.get('/api/hotels');
            this.hotels = response.data;
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        async getRates() {
            if (!this.startDate || !this.selectedHotel) {
                this.error = 'Please select both a date and a hotel.';
                return;
            } else {
                this.error = ''
            }
            try {
                const response = await axios.get(`/api/rates/all?start_date=${this.startDate}&hotel_id=${this.selectedHotel}`);
                const data = response.data;

                const labels = data.map(item => item.date_of_stay);
                const rates = data.map(item => item.rate_per_night);

                if (this.chart) {
                    this.chart.destroy();
                }

                const ctx = document.getElementById('myChart');
                this.chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Rate per Night',
                            data: rates,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    }
                });
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>

<style scoped>
.dashboard {
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

.input-wrapper {
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

.error {
    color: red;
    font-weight: bold;
    margin-bottom: 10px;
}

.main-btn {
    background-color: black;
    color: white;
    margin-left: 10px;
}

@media only screen and (min-width: 40rem) {
    .dashboard,
    .input-date,
    .btn {
        font-size: 19px;
        line-height: 1.31579;
    }
}
</style>
