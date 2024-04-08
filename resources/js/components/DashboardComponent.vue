<template>

    <div class="row justify-content-center mb-3">
        <div class="col-md-3">
            <select class="form-control" v-model="chart_type" @click="changeChartType">
            <option value="bar">Bar Chart</option>
            <option value="line">Line Chart</option>
        </select>
        </div>
    </div>
   <TasksBarChart v-if="chart_type =='bar'"/>
   <TasksLineChart v-if="chart_type =='line'"/>
</template>

<script>

import TasksBarChart from './tasks/TasksBarChart.vue'
import TasksLineChart from './tasks/TasksLineChart.vue'

    export default {
        components: {
            TasksBarChart,
            TasksLineChart,
        },
        data() {
            return {
                chart_type: 'bar',
            }
        },

        methods: {
            changeChartType(event) {
                this.chart_type = event.target.value
            }
        }
        
    }
</script>