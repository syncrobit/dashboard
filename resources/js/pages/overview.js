$(document).ready(function () {
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
      action: "GET_ORACLE_PRICE",
    },
    success: function (response) {
      $(".oracle-price").html("$" + response.data.price);
      $(".oracle-diff").html(response.data.diff);
      $(".oracle-graph").html(response.data.graph);

      $(".oracle-graph").sparkline("html", {
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
      action: "GET_DAILY_EARNINGS",
    },
    success: function (response) {
      $(".wtoday-rewards").html(response.data.total_rewards + " HNT");
      //$('.oracle-diff').html(response.data.diff);
      $(".today-reward-graph").html(response.data.graph);

      $(".today-reward-graph").sparkline("html", {
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
      action: "GET_TOTAL_REWARDS",
    },
    success: function (response) {
      $(".total-earnings-w").html(response.data.total_rewards + " HNT");
      //$('.oracle-diff').html(response.data.diff);
      $(".wtotal-earnings").html(response.data.graph);

      $(".wtotal-earnings").sparkline("html", {
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

  var optionsWeekEarnings = {
    chart: {
      id: "weeklyEarningsGraph",
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
        name: "Rewards",
        data: [],
      },
    ],
    xaxis: {
      type: "category",
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
          return val + " HNT";
        },
      },
    },
  };

  var weeklyChart = new ApexCharts(
    document.querySelector("#weekly_earnings"),
    optionsWeekEarnings
  );
  weeklyChart.render();

  $.ajax({
    url: baseUri,
    method: "POST",
    dataType: "json",
    data: {
      action: "GET_WEEKLY_GRAPH",
    },
    success: function (response) {
      $(".weekly-graph-earnings").html(response.data.weekly_sum + " HNT");
      var $series = response.data.graph.series;

      if (!$.isArray($series) || !$series.length) {
        weeklyChart.updateOptions({
          noData: {
            text: "No Rewards...",
          },
        });
      } else {
        weeklyChart.updateOptions({
          series: [
            {
              name: "Rewards",
              data: $series,
            },
          ],
          xaxis: {
            type: "category",
            categories: response.data.graph.categories,
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
    },
  });

  var optionsMonthlyEarnings = {
    chart: {
      height: 249,
      type: "bar",
      toolbar: {
        show: false,
      },
      fontFamily: "Nunito, sans-serif",
    },
    colors: ["#f93a5a", "#036fe7", "#f7a556"],
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
    series: [
      {
        name: "Rewards",
        data: [],
      },
    ],
    xaxis: {
      type: "category",
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
    tooltip: {
      y: {
        formatter: function (val) {
          return val + " HNT";
        },
      },
    },
  };
  var monthlyGraph = new ApexCharts(
    document.querySelector("#monthly_earnings"),
    optionsMonthlyEarnings
  );
  monthlyGraph.render();

  $.ajax({
    url: baseUri,
    method: "POST",
    dataType: "json",
    data: {
      action: "GET_MONTHLY_GRAPH",
    },
    success: function (response) {
      $(".wmonthly-rewards-sum").html(response.data.monthly_sum + " HNT");
      var $series = response.data.graph.series;

      if (!$.isArray($series) || !$series.length) {
        monthlyGraph.updateOptions({
          noData: {
            text: "No Rewards...",
          },
        });
      } else {
        monthlyGraph.updateOptions({
          series: [
            {
              name: "Rewards",
              data: $series,
            },
          ],
          xaxis: {
            type: "category",
            categories: response.data.graph.categories,
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
    },
  });

  //Change Wallet
  $('.u_wallet_select').on('select2:select', function (e) {
    console.log(e.params.data.id);
  });
});
