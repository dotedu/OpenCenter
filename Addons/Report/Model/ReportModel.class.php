<?php
namespace Addons\Report\Model;

use Think\Model;

class ReportModel extends Model
{
    protected $_auto = array(
        array('create_time', NOW_TIME, self::MODEL_INSERT),
        array('update_time', NOW_TIME, self::MODEL_BOTH),
        array('status', 2, self::MODEL_BOTH),
    );

    public function addData($data = array())
    {
        $data = $this->create($data);
        return $this->add($data);
    }

    public function processingTime()
    {
        $ptime = $this->create(array('handle_time', NOW_TIME, self::MODEL_BOTH));
        return $this->save($ptime);

    }

}