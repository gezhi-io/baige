<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', '百舸') }}</title>
    <link rel="icon" href="logo.svg" type="svg" sizes="any" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="bg-gray-100 font-family-karla flex">
    @include('layouts.aside-menu')
    <div class="w-full flex flex-col h-screen overflow-y-hidden">
        @include('layouts.header')
        <div class="w-full overflow-x-hidden border-t flex flex-col p-10 pb-0">
            <main>
                {{ $slot }}
            </main>
            
        </div>
        <footer class="w-full bg-white text-center p-4 mt-4">
            本程序由 <a target="_blank" href="https://github.com/gezhi-io" class="underline">gezhi.io</a> 创建.
        </footer>
    </div>
    
</body>
 <!-- Font Awesome -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
 <!-- ChartJS -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
 @stack('js')
 <script>
    
     var chartOne = document.getElementById('chartOne');
     var myChart = new Chart(chartOne, {
         type: 'bar',
         data: {
             labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
             datasets: [{
                 label: '# of Votes',
                 data: [12, 19, 3, 5, 2, 3],
                 backgroundColor: [
                     'rgba(255, 99, 132, 0.2)',
                     'rgba(54, 162, 235, 0.2)',
                     'rgba(255, 206, 86, 0.2)',
                     'rgba(75, 192, 192, 0.2)',
                     'rgba(153, 102, 255, 0.2)',
                     'rgba(255, 159, 64, 0.2)'
                 ],
                 borderColor: [
                     'rgba(255, 99, 132, 1)',
                     'rgba(54, 162, 235, 1)',
                     'rgba(255, 206, 86, 1)',
                     'rgba(75, 192, 192, 1)',
                     'rgba(153, 102, 255, 1)',
                     'rgba(255, 159, 64, 1)'
                 ],
                 borderWidth: 1
             }]
         },
         options: {
             scales: {
                 yAxes: [{
                     ticks: {
                         beginAtZero: true
                     }
                 }]
             }
         }
     });

     var chartTwo = document.getElementById('chartTwo');
     var myLineChart = new Chart(chartTwo, {
         type: 'line',
         data: {
             labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
             datasets: [{
                 label: '# of Votes',
                 data: [12, 19, 3, 5, 2, 3],
                 backgroundColor: [
                     'rgba(255, 99, 132, 0.2)',
                     'rgba(54, 162, 235, 0.2)',
                     'rgba(255, 206, 86, 0.2)',
                     'rgba(75, 192, 192, 0.2)',
                     'rgba(153, 102, 255, 0.2)',
                     'rgba(255, 159, 64, 0.2)'
                 ],
                 borderColor: [
                     'rgba(255, 99, 132, 1)',
                     'rgba(54, 162, 235, 1)',
                     'rgba(255, 206, 86, 1)',
                     'rgba(75, 192, 192, 1)',
                     'rgba(153, 102, 255, 1)',
                     'rgba(255, 159, 64, 1)'
                 ],
                 borderWidth: 1
             }]
         },
         options: {
             scales: {
                 yAxes: [{
                     ticks: {
                         beginAtZero: true
                     }
                 }]
             }
         }
     });
 </script>
</html>
