<?php
/**
 * 
 * @authors ${任清麟} 
 * @date    2018-01-19 10:40:52
 * @version $Id$
 */
//声明命名空间
namespace Admin\Model;
//引入父类模型
use Think\Model;
class AdviceModel extends Model{
	//通过属性指定关联的数据表名称
	protected $trueTableName    =   'advice';
	
	/* // 数据表名（不包含表前缀）
    protected $tableName        =   '';
    // 实际数据表名（包含表前缀）
    protected $trueTableName    =   '';*/
}