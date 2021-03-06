<?php
/**
 * @author: helei
 * @createTime: 2016-07-22 17:02
 * @description:
 */

namespace thinkweb\zapay\Common\Yinlian\Data\Charge;


use thinkweb\zapay\Common\PayException;
use thinkweb\zapay\Utils\ArrayUtil;

class B2bChargeData extends ChargeBaseData
{
    /**
     * 构建 APP支付 加密数据
     * @author helei
     */
    protected function buildData(){
        $signData = [
            //以下信息非特殊情况不需要改动
            'version' => $this->version,                 //版本号
            'encoding' => 'utf-8',				  //编码方式
            'txnType' => '01',				      //交易类型
            'txnSubType' => '01',				  //交易子类
            'bizType' => '000202',				  //业务类型
            'frontUrl' =>  $this->frontUrl,  //前台通知地址
            'backUrl' => $this->backUrl,	  //后台通知地址
            'signMethod' => $this->signMethod,	              //签名方法
            'channelType' => '07',	              //渠道类型，07-PC，08-手机
            'accessType' => '0',		          //接入类型
            'currencyCode' => '156',	          //交易币种，境内商户固定156

            //TODO 以下信息需要填写
            'merId' => $this->merId,		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
            'orderId' => $this->order_no,	//商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
            'txnTime' => date('YmdHis'),	//订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
            'txnAmt' => intval($this->amount * 100),	//交易金额，单位分，此处默认取demo演示页面传递的参数

            // 订单超时时间。
            // 超过此时间后，除网银交易外，其他交易银联系统会拒绝受理，提示超时。 跳转银行网银交易如果超时后交易成功，会自动退款，大约5个工作日金额返还到持卡人账户。
            // 此时间建议取支付时的北京时间加15分钟。
            // 超过超时时间调查询接口应答origRespCode不是A6或者00的就可以判断为失败。
            'payTimeout' => date('YmdHis', strtotime('+15 minutes')),

            // 请求方保留域，
            // 透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据。
            // 出现部分特殊字符时可能影响解析，请按下面建议的方式填写：
            // 1. 如果能确定内容不会出现&={}[]"'等符号时，可以直接填写数据，建议的方法如下。
            //    'reqReserved' =>'透传信息1|透传信息2|透传信息3',
            // 2. 内容可能出现&={}[]"'符号时：
            // 1) 如果需要对账文件里能显示，可将字符替换成全角＆＝｛｝【】“‘字符（自己写代码，此处不演示）；
            // 2) 如果对账文件没有显示要求，可做一下base64（如下）。
            //    注意控制数据长度，实际传输的数据长度不能超过1024位。
            //    查询、通知等接口解析时使用base64_decode解base64后再对数据做后续解析。
            //    'reqReserved' => base64_encode('任意格式的信息都可以'),

            //TODO 其他特殊用法：
            //【直接跳转发卡行网银】
            //（因测试环境所有商户号都默认不允许开通网银支付权限，所以要实现此功能需要使用正式申请的商户号去生产环境测试）：
            // 1）联系银联业务运营部门开通商户号的网银前置权限
            // 2）上送issInsCode字段，该字段的值参考《平台接入接口规范-第5部分-附录》（全渠道平台银行名称-简码对照表）
            //'issInsCode' => 'ABC',  //发卡机构代码
        ];
        // 移除数组中的空值
        $this->retData = ArrayUtil::paraFilter($signData);
    }

    protected function checkDataParam(){
        parent::checkDataParam(); // TODO: Change the autogenerated stub
    }

}