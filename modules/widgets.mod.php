<?php 
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class SB_WIDGETS{

    public static function getBlocksWidget(){
        $return  = '<div class="card overflow-hidden sales-card bg-primary-gradient">';
        $return .= '<div class="pl-3 pt-3 pr-3 pb-2 pt-0">';
        $return .= '<div class="">';
        $return .= '<h6 class="mb-3 tx-12 text-white">BLOCKCHAIN HEIGHT</h6>';
        $return .= '</div>';
        $return .= '<div class="pb-0 mt-0">';
        $return .= '<div class="d-flex">';
        $return .= '<div class="">';
        $return .= '<h4 class="tx-20 font-weight-bold mb-1 text-white blockchain-height">';
        $return .= 'Loading...';
        $return .= '</h4>';
        $return .= '<p class="mb-0 tx-12 text-white op-7">Block Time</p>';
        $return .= '</div>';
        $return .= '<span class="float-right my-auto ml-auto">';
        $return .= '<i class="fad fa-clock text-white"></i>';
        $return .= '<span class="text-white op-7 block-time">&nbsp;</span>';
        $return .= '</span>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<span id="blocktimes-graph" class="pt-1 blocktimes-graph" style="height:35px;">&nbsp;</span>';
        $return .= '</div>';

        return $return;
    }

    public static function oraclePrice(){
        $return  = '<div class="card overflow-hidden sales-card bg-warning-gradient">';
        $return .= '<div class="pl-3 pt-3 pr-3 pb-2 pt-0">';
        $return .= '<div class="">';
        $return .= '<h6 class="mb-3 tx-12 text-white">HNT ORACLE PRICE</h6>';
        $return .= '</div>';
        $return .= '<div class="pb-0 mt-0">';
        $return .= '<div class="d-flex">';
        $return .= '<div class="">';
        $return .= '<h4 class="tx-20 font-weight-bold mb-1 text-white oracle-price">Loading...</h4>';
        $return .= '<p class="mb-0 tx-12 text-white op-7">Compared to last oracle price</p>';
        $return .= '</div>';
        $return .= '<span class="float-right my-auto ml-auto oracle-diff">&nbps;</span>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<span id="oracle-graph" class="pt-1 oracle-graph" style="height:35px;">&nbsp;</span>';
        $return .= '</div>';

        return $return;
    }

    public static function getDailyEarnings(){
        $return  = '<div class="card overflow-hidden sales-card bg-danger-gradient">';
        $return .= '<div class="pl-3 pt-3 pr-3 pb-2 pt-0">';
        $return .= '<div class="">';
        $return .= '<h6 class="mb-3 tx-12 text-white">TODAY\'S EARNINGS</h6>';
        $return .= '</div>';
        $return .= '<div class="pb-0 mt-0">';
        $return .= '<div class="d-flex">';
        $return .= '<div class="">';
        $return .= '<h4 class="tx-20 font-weight-bold mb-1 text-white wtoday-rewards">Loading...</h4>';
        $return .= '<p class="mb-0 tx-12 text-white op-7">Compared to yesterday</p>';
        $return .= '</div>';
        $return .= '<span class="float-right my-auto ml-auto">';
        $return .= '<i class="fas fa-arrow-circle-down text-white"></i>';
        $return .= '<span class="text-white op-7"> -23.09%</span>';
        $return .= '</span>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<span id="today-reward-graph" class="pt-1 today-reward-graph" style="height:35px;">&nbsp;</span>';
        $return .= '</div>';

        return $return;
    }

    public static function totalEarnings(){
        $return  = '<div class="card overflow-hidden sales-card bg-success-gradient">';
        $return .= '<div class="pl-3 pt-3 pr-3 pb-2 pt-0">';
        $return .= '<div class="">';
        $return .= '<h6 class="mb-3 tx-12 text-white">TOTAL EARNINGS</h6>';
        $return .= '</div>';
        $return .= '<div class="pb-0 mt-0">';
        $return .= '<div class="d-flex">';
        $return .= '<div class="">';
        $return .= '<h4 class="tx-20 font-weight-bold mb-1 text-white total-earnings-w">Loading...</h4>';
        $return .= '<p class="mb-0 tx-12 text-white op-7">Compared to last week</p>';
        $return .= '</div>';
        $return .= '<span class="float-right my-auto ml-auto">';
        $return .= '<i class="fas fa-arrow-circle-up text-white"></i>';
        $return .= '<span class="text-white op-7"> 52.09%</span>';
        $return .= '</span>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<span id="wtotal-earnings" class="pt-1 wtotal-earnings" style="height:35px;">&nbsp;</span>';
        $return .= '</div>';

        return $return;
    }

    public static function getWeeklyEarnings(){
        $return  = '<div class="card">';
        $return .= '<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">';
        $return .= '<div class="d-flex justify-content-between">';
        $return .= '<h4 class="card-title mb-0">Past 7 days earnings</h4>';
        $return .= '</div>';
        $return .= '<p class="tx-12 text-muted mb-0">Your earnings for the past 7 days.</p>';
        $return .= '</div>';
        $return .= '<div class="card-body">';
        $return .= '<div class="total-revenue">';
        $return .= '<div>';
        $return .= '<h4 class="weekly-graph-earnings">Loading...</h4>';
        $return .= '<label><span class="bg-primary"></span>Rewards</label>';
        $return .= '</div>';
        $return .= '<div>';
        $return .= '</div>';
        $return .= '<div>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<div id="weekly_earnings" class="sales-bar mt-4"></div>';
        $return .= '</div>';
        $return .= '</div>';    

        return $return;
    }

    public static function getMonthlyEarnings(){
        $return  = '<div class="card">';
        $return .= '<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">';
        $return .= '<div class="d-flex justify-content-between">';
        $return .= '<h4 class="card-title mb-0">Past 30 days earnings</h4>';
        $return .= '</div>';
        $return .= '<p class="tx-12 text-muted mb-0">Your earnings for the past 30 days.</p>';
        $return .= '</div>';
        $return .= '<div class="card-body">';
        $return .= '<div class="total-revenue">';
        $return .= '<div>';
        $return .= '<h4 class="wmonthly-rewards-sum">Loading...</h4>';
        $return .= '<label><span class="bg-danger"></span>Rewards</label>';
        $return .= '</div>';
        $return .= '<div>';
        $return .= '</div>';
        $return .= '<div>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<div id="monthly_earnings" class="sales-bar mt-4"></div>';
        $return .= '</div>';
        $return .= '</div>';

        return $return;
    }

    
    public static function top10EarningHS(){
        $return  = '<div class="card card-dashboard-map-one">';
        $return .= '<label class="main-content-label">Top Earning Hotspots</label>';
        $return .= '<span class="d-block mg-b-20 text-muted tx-12">Your top earning hotspots</span>';
        $return .= '<div class="">';
        $return .= SB_HELIUM::getHotSpots();
        $return .= '</div>';
        $return .= '</div>';

        return $return;
    }

    public static function getTotalHotspots(){

        $return  = '<div class="card overflow-hidden sales-card bg-danger-gradient">';
        $return .= '<div class="pl-3 pt-3 pr-3 pb-2 pt-0">';
        $return .= '<div class="">';
        $return .= '<h6 class="mb-3 tx-12 text-white">NETWORK TOTAL HOTSPOTS</h6>';
        $return .= '</div>';
        $return .= '<div class="pb-0 mt-0">';
        $return .= '<div class="d-flex">';
        $return .= '<div class="">';
        $return .= '<h4 class="tx-20 font-weight-bold mb-1 text-white wtotal-hs">Loading...</h4>';
        $return .= '<p class="mb-0 tx-12 text-white op-7">From which currently active</p>';
        $return .= '</div>';
        $return .= '<span class="float-right my-auto ml-auto">';
        $return .= '<span class="text-white op-7 wactive-hs"></span>';
        $return .= '</span>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<span id="compositeline2" class="pt-1" style="height:35px;">&nbsp;</span>';
        $return .= '</div>';

        return $return;
    }

    public static function lastCGElection(){
        $times = SB_HELIUM::getElectionTimes();

        $return  = '<div class="card overflow-hidden sales-card bg-success-gradient">';
        $return .= '<div class="pl-3 pt-3 pr-3 pb-2 pt-0">';
        $return .= '<div class="">';
        $return .= '<h6 class="mb-3 tx-12 text-white">LAST CG ELECTION</h6>';
        $return .= '</div>';
        $return .= '<div class="pb-0 mt-0">';
        $return .= '<div class="d-flex">';
        $return .= '<div class="">';
        $return .= '<h4 class="tx-20 font-weight-bold mb-1 text-white cg-el-block">Loading...</h4>';
        $return .= '<p class="mb-0 tx-12 text-white op-7">Election time</p>';
        $return .= '</div>';
        $return .= '<span class="float-right my-auto ml-auto">';
        $return .= '<span class="text-white op-7 cg-el-time">&nbsp;</span>';
        $return .= '</span>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<span id="cg-el-graph" class="pt-1 cg-el-graph" style="height:35px;">&nbsp;</span>';
        $return .= '</div>';

        return $return;
    }

    public static function circulatingSupply(){
        $return  = '<div class="card overflow-hidden sales-card bg-warning-gradient">';
        $return .= '<div class="pl-3 pt-3 pr-3 pb-2 pt-0">';
        $return .= '<div class="">';
        $return .= '<h6 class="mb-3 tx-12 text-white">CIRCULATING HNT SUPPLY</h6>';
        $return .= '</div>';
        $return .= '<div class="pb-0 mt-0">';
        $return .= '<div class="d-flex">';
        $return .= '<div class="">';
        $return .= '<h4 class="tx-20 font-weight-bold mb-1 text-white total-token-supply">Loading...</h4>';
        $return .= '<p class="mb-0 tx-12 text-white op-7">Coins minted each month</p>';
        $return .= '</div>';
        $return .= '<span class="float-right my-auto ml-auto monthly-reward"></span>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
        $return .= '<span id="circulating-supply" class="pt-1" style="height:35px;">&nbsp;</span>';
        $return .= '</div>';

        return $return;
    }

    public static function getDCUsage(){
		$return  = '<div class="card">';
		$return .= '<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">';
		$return .= '<div class="d-flex justify-content-between">';
		$return .= '<h4 class="card-title mb-0">Data Credits Usage</h4>';
		$return .= '</div>';
		$return .= '<p class="tx-12 text-muted mb-0">Network Data Credits usage for the past 7 days</p>';
		$return .= '</div>';
		$return .= '<div class="card-body">';
		$return .= '<div class="total-revenue">';
		$return .= '<div>';
		$return .= '<h4 class="dc-usage-total">Loading...</h4>';
		$return .= '<label><span class="bg-primary"></span>Data Credits</label>';
		$return .= '</div>';
		$return .= '<div>';
		$return .= '<h4 class="pkts-usage-total">Loading...</h4>';
		$return .= '<label><span class="bg-danger"></span>Packets</label>';
		$return .= '</div>';
		$return .= '<div>';
		$return .= '</div>';
		$return .= '</div>';
		$return .= '<div id="dc_usage" class="sales-bar mt-4 dc_usage"></div>';
		$return .= '</div>';
        $return .= '</div>';

    
        return $return;
    }

    public static function getDCUsageUSD(){
		$return  = '<div class="card">';
		$return .= '<div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">';
		$return .= '<div class="d-flex justify-content-between">';
		$return .= '<h4 class="card-title mb-0">Data Credits Usage in USD</h4>';
		$return .= '</div>';
		$return .= '<p class="tx-12 text-muted mb-0">Network Data Credits usage in USD for the past 7 days</p>';
		$return .= '</div>';
		$return .= '<div class="card-body">';
		$return .= '<div class="total-revenue">';
		$return .= '<div>';
		$return .= '<h4 class="dc-usage-usd-total">Loading...</h4>';
		$return .= '<label><span class="bg-warning"></span>Data Credits USD</label>';
		$return .= '</div>';
		$return .= '<div>';
		$return .= '</div>';
		$return .= '<div>';
		$return .= '</div>';
		$return .= '</div>';
		$return .= '<div id="dc_usage_usd" class="sales-bar mt-4 dc_usage_usd"></div>';
		$return .= '</div>';
        $return .= '</div>';

    
        return $return;
    }

    public static function getBlockAverageTimes(){
        $return  = '<div class="card overflow-hidden">';
		$return .= '<div class="card-body">';
		$return .= '<div class="main-content-label mg-b-5">Average Block Time</div>';
		$return .= '<div class="chartjs-wrapper-demo">';
		$return .= '<canvas id="chartArea1"></canvas>';
		$return .= '</div>';
		$return .= '</div>';
        $return .= '</div>';
        
        return $return;
    }
}