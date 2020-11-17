<?php
    $db = new Database();
    $sql = "select count(*) as vehicle_empty from vehicle where vehicle_state = 0"; //lay xe  trong
    $temp = $db->select($sql);
    $vehicle_empty = $temp[0];

    $sql = "select count(*) as vehicle_rent from vehicle where vehicle_state = 1"; //lay xe dang cho thue
    $temp = $db->select($sql);
    $vehicle_rent = $temp[0];

    $statistical_day = $db->select("select rent_expense, start_time, finish_time from vehicle join rent_detail on vehicle.vehicle_id=rent_detail.vehicle_id where day(finish_time) = day(curdate())");
    
    $total_money_day = 0;
    $i = 0;
    if(!empty($statistical_day)){
        while($i < count($statistical_day)){
            $row = $statistical_day[$i];
            $total_second = strtotime($row['finish_time']) - strtotime($row['start_time']);
            $total_minute = floor($total_second / 60);
            $money = floor($row['rent_expense'] / 60 * $total_minute);
            $money_format = $db->formatMoney($money);
            $total_money_day += $money_format;
            $i++;
        }
    }

    $statistical_month = $db->select("select rent_expense, start_time, finish_time from vehicle join rent_detail on vehicle.vehicle_id=rent_detail.vehicle_id where month(finish_time) = month(curdate())");
    $total_money_month = 0;
    $i = 0;
    if(!empty($statistical_month)){
        while($i < count($statistical_month)){
            $row = $statistical_month[$i];
            $total_second = strtotime($row['finish_time']) - strtotime($row['start_time']);
            $total_minute = floor($total_second / 60);
            $money = floor($row['rent_expense'] / 60 * $total_minute);
            $money_format = $db->formatMoney($money);
            $total_money_month += $money_format;
            $i++;
        }
    }
?>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                            Xe đang trống</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $vehicle_empty['vehicle_empty'];?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-bicycle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-sm font-weight-bold text-success text-uppercase mb-1">
                            Xe đang cho thuê</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $vehicle_rent['vehicle_rent'];?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-motorcycle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-sm font-weight-bold text-info text-uppercase mb-1">
                            Doanh thu ngày</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($total_money_day, 0, '', ','). ' đ';?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-sm font-weight-bold text-warning text-uppercase mb-1">
                            Doanh thu tháng </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($total_money_month, 0, '', ','). ' đ';?></div>
                    </div>
                    <div class="col-auto">
                    <i class="far fa-money-bill-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>