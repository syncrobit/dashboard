$(document).ready(function () {
  $.ajax({
    url: baseUri,
    method: "POST",
    dataType: "json",
    data: {
      action: "GET_BLOCK_TIMES",
    },
    success: function (response) {
      $(".blockchain-height").html(response.data.chain_height);
      $(".block-time").html(response.data.block_time + "s");
      $(".blocktimes-graph").html(response.data.block_chart);

      $(".blocktimes-graph").sparkline("html", {
        lineColor: "rgba(255, 255, 255, 0.6)",
        lineWidth: 2,
        spotColor: false,
        minSpotColor: false,
        maxSpotColor: false,
        highlightSpotColor: null,
        highlightLineColor: null,
        fillColor: "rgba(255, 255, 255, 0.2)",
        width: "100%",
        height: 30,
        disableTooltips: true,
      });
    },
  });

  $.ajax({
    url: baseUri,
    method: "POST",
    dataType: "json",
    data: {
      action: "NETWORK_HOTSPOTS",
    },
    success: function (response) {
      $(".wtotal-hs").html(response.data.total_hs);
      $(".wactive-hs").html(response.data.available_hs);
    },
  });

  $.ajax({
    url: baseUri,
    method: "POST",
    dataType: "json",
    data: {
      action: "CG_ELECTION_TIME",
    },
    success: function (response) {
      console.log(response);
      $(".cg-el-block").html(response.data.election_time);
      $(".cg-el-time").html(response.data.graph.time + " mins");
      $(".cg-el-graph").html(response.data.graph.times);

      $(".cg-el-graph").sparkline("html", {
        lineColor: "rgba(255, 255, 255, 0.6)",
        lineWidth: 2,
        spotColor: false,
        minSpotColor: false,
        maxSpotColor: false,
        highlightSpotColor: null,
        highlightLineColor: null,
        fillColor: "rgba(255, 255, 255, 0.2)",
        width: "100%",
        height: 30,
        disableTooltips: true,
      });
    },
  });

  $.ajax({
    url: baseUri,
    method: "POST",
    dataType: "json",
    data: {
      action: "TOKEN_SUPPLY",
    },
    success: function (response) {
      $(".total-token-supply").html(response.data.total_supply + " HNT");
      $(".monthly-reward").html(response.data.m_supply);
    },
  });

  window.Apex = {
    chart: {
      foreColor: "#77778e",
      toolbar: {
        show: false,
      },
    },
    dataLabels: {
      enabled: false,
    },
    tooltip: {
      theme: "dark",
    },
    grid: {
      borderColor: "rgba(119, 119, 142, 0.2)",
      xaxis: {
        lines: {
          show: true,
        },
      },
    },
  };

  /* Apexcharts (#dc_usage) */
  var dcUsage = {
    chart: {
      height: 249,
      type: "bar",
      toolbar: {
        show: false,
      },
      fontFamily: "Nunito, sans-serif",
    },
    colors: ["#036fe7", "#f93a5a", "#f7a556"],
    plotOptions: {
      bar: {
        dataLabels: {
          enabled: false,
        },
        columnWidth: "42%",
        endingShape: "rounded",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      endingShape: "rounded",
      colors: ["transparent"],
    },
    series: [
      {
        name: "Data Credits",
        data: [],
      },
      {
        name: "Packets",
        data: [],
      },
    ],
    xaxis: {
      categories: [],
    },
    fill: {
      opacity: 1,
    },
    legend: {
      show: false,
      floating: true,
      position: "top",
      horizontalAlign: "left",
    },
    noData: {
      text: "Loading...",
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val;
        },
      },
    },
  };
  var $dc_usage = new ApexCharts(document.querySelector("#dc_usage"), dcUsage);
  $dc_usage.render();

  $.ajax({
    url: baseUri,
    method: "POST",
    dataType: "json",
    data: {
      action: "GET_DC_USAGE_7DAYS",
    },
    success: function (response) {
      $(".dc-usage-total").html(response.data.dcs_sum_formatted);
      $(".pkts-usage-total").html(response.data.pkts_sum_formatted);
      var $pkts = response.data.pkts

      if (!$.isArray($pkts) || !$pkts.length) {
        $dc_usage.updateOptions({
          noData: {
            text: "No data available...",
          },
        });
      } else {
        $dc_usage.updateOptions({
          series: [
            {
              name: "Data Credits",
              data: response.data.dcs,
            },
            {
              name: "Packets",
              data: $pkts,
            },
          ],
          xaxis: {
            type: "category",
            categories: response.data.dates,
          },
          responsive: [
            {
              breakpoint: 576,
              options: {
                stroke: {
                  show: true,
                  width: 1,
                  endingShape: "rounded",
                  colors: ["transparent"],
                },
              },
            },
          ],
        });
      }
    }
  });

  var dcUsageUSD = {
    chart: {
      height: 249,
      type: "bar",
      toolbar: {
        show: false,
      },
      fontFamily: "Nunito, sans-serif",
    },
    colors: ["#f7a556", "#f93a5a", "#036fe7"],
    plotOptions: {
      bar: {
        dataLabels: {
          enabled: false,
        },
        columnWidth: "42%",
        endingShape: "rounded",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 2,
      endingShape: "rounded",
      colors: ["transparent"],
    },
    series: [
      {
        name: "USD",
        data: [],
      },
    ],
    xaxis: {
      categories: [],
    },
    fill: {
      opacity: 1,
    },
    legend: {
      show: false,
      floating: true,
      position: "top",
      horizontalAlign: "left",
    },
    noData: {
      text: "Loading...",
    },
    tooltip: {
      y: {
        formatter: function (val) {
          return val + " USD";
        },
      },
    },
  };
  var $dc_usage_usd = new ApexCharts(
    document.querySelector("#dc_usage_usd"),
    dcUsageUSD
  );
  $dc_usage_usd.render();

  $.ajax({
    url: baseUri,
    method: "POST",
    dataType: "json",
    data: {
      action: "GET_DC_USD_7DAYS",
    },
    success: function (response) {
      $(".dc-usage-usd-total").html(response.data.usd_sum_formatted + " USD");
      var $usd = response.data.usd;

      if (!$.isArray($usd) || !$usd.length) {
        $dc_usage_usd.updateOptions({
          noData: {
            text: "No data available...",
          },
        });
      } else {
        $dc_usage_usd.updateOptions({
          series: [
            {
              name: "USD",
              data: $usd,
            },
          ],
          xaxis: {
            type: "category",
            categories: response.data.dates,
          },
          responsive: [
            {
              breakpoint: 576,
              options: {
                stroke: {
                  show: true,
                  width: 1,
                  endingShape: "rounded",
                  colors: ["transparent"],
                },
              },
            },
          ],
        });
      }
    }
  });

  var ctx9 = document.getElementById("chartArea1").getContext('2d');
  var gradient1 = ctx9.createLinearGradient(0, 350, 0, 0);
  gradient1.addColorStop(0, 'rgba(247, 85, 122,0)');
  gradient1.addColorStop(1, 'rgba(247, 85, 122,.5)');
  var gradient2 = ctx9.createLinearGradient(0, 280, 0, 0);
  gradient2.addColorStop(0, 'rgba(0,123,255,0)');
  gradient2.addColorStop(1, 'rgba(0,123,255,.3)');
  new Chart(ctx9, {
    type: "line",
    data: {
      labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "July",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      datasets: [
        {
          data: [12, 15, 18, 40, 35, 38, 32, 20, 25, 15, 25, 30],
          borderColor: "#f7557a",
          borderWidth: 1,
          backgroundColor: gradient1,
        },
        {
          data: [10, 20, 25, 55, 50, 45, 35, 37, 45, 35, 55, 40],
          borderColor: "#007bff",
          borderWidth: 1,
          backgroundColor: gradient2,
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      legend: {
        display: false,
        labels: {
          display: false,
        },
      },
      scales: {
        yAxes: [
          {
            ticks: {
              beginAtZero: true,
              fontSize: 10,
              max: 80,
              fontColor: "rgba(171, 167, 167,0.9)",
            },
            gridLines: {
              display: true,
              color: "rgba(171, 167, 167,0.2)",
              drawBorder: false,
            },
          },
        ],
        xAxes: [
          {
            ticks: {
              beginAtZero: true,
              fontSize: 11,
              fontColor: "rgba(171, 167, 167,0.9)",
            },
            gridLines: {
              display: true,
              color: "rgba(171, 167, 167,0.2)",
              drawBorder: false,
            },
          },
        ],
      },
    },
  });
});
