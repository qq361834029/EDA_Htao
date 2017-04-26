<?php
return array(
	'CAINIAO_REQUEST_FIELDS'	=> array(
									/* 签收接口
									 * 场景：中转仓收到包裹后，
									 * 首先进行签收，
									 * 并将签收消息发送给菜鸟。
									 */
									'TRANSIT_WAREHOUSE_SIGN'				=> array(//签收
																				'logisticsOrderCode',							//*//退货物流单号，简称LP号
																				'occurTime',									//*//业务发生时间，格式：yyyy-MM-dd HH:mm:ss
																				'timeZone'				=> 0,					//时区，如果东八区则值为8，西八区则为-8 默认北京时间
																				'result'				=> array(//实操结果信息
																											'success',			//*//实操结果 成功：true，失败：false
																											'code'		=> 0,	//对于失败情况，回传原因描述，请回传对应的数字 01：包裹破损拒收 02：包裹运单到付拒收
																											'desc'		=> 0,	//描述
																										),
																			),
									/**
									 * 丢弃接口
									 * 场景：在卖家同意丢弃包裹后，
									 * 待cp将包裹丢弃，
									 * 需要给菜鸟回传确认丢弃报文。
									 */
									'TRANSIT_WAREHOUSE_INNER_CHECK_CONFIRM'	=> array(//丢弃
																				'logisticsOrderCode',							//*//退货物流单号，简称LP号
																				'occurTime',									//*//业务发生时间，格式：yyyy-MM-dd HH:mm:ss
																				'timeZone'				=> 0,					//时区，如果东八区则值为8，西八区则为-8 默认北京时间
																				'result'				=> array(				//实操结果信息
																											'success',			//*//实操结果 成功：true，失败：false
																											'desc'		=> 0,	//描述
																										),
																			),
									/**
									 * 入库接口
									 * 场景：中转仓在操作包裹入库后，
									 * 需要将入库信息发送给菜鸟
									 */
									'TRANSIT_WAREHOUSE_INBOUND'				=> array(//入库
																				'logisticsOrderCode',							//*//退货物流单号，简称LP号
																				'occurTime',									//*//业务发生时间，格式：yyyy-MM-dd HH:mm:ss
																				'timeZone'				=> 0,					//时区，如果东八区则值为8，西八区则为-8 默认北京时间
																				'packageWeight',								//包裹称重重量
																				'weightUnit'			=> 0,					//重量单位，默认克(g)
																				'hasBatteryOper'		=> 0,					//是否有拆电池操作，true:有，false:无 默认：false
																				'result'				=> array(				//实操结果信息
																											'success',			//*//实操结果 成功：true，失败：false
																											'code'		=> 0,	//对于失败情况，回传原因描述，请回传对应的数字 01：单号无法识别，系统同步问题 02：货物与品名不符 03：未通过安检 04：实收件数与系统退货件数不符
																											'desc'		=> 0,	//描述
																											'imgUrl'	=> 0,	//图片url，多个用“|”隔开
																										),
																			),
									/**
									 * 出库接口
									 * 场景：中转仓在操作包裹出库后，
									 * 需要将出库信息回传给菜鸟。
									 */
									'TRANSIT_WAREHOUSE_OUTBOUND'			=> array(//出库
																				'logisticsOrderCode',							//*//退货物流单号，简称LP号
																				'occurTime',									//*//业务发生时间，格式：yyyy-MM-dd HH:mm:ss
																				'timeZone'				=> 0,					//时区，如果东八区则值为8，西八区则为-8 默认北京时间
																				'batchNo',										//*//出库批次号
																				'packageCode',									//*//出库大包裹编号
																				'packageWeight',								//*//大包裹总重
																				'weightUnit'			=> 0,					//重量单位，默认克(g)
																				'includedNum'			=> 0,					//大包裹包含的小包裹数
																				'result'				=> array(//实操结果信息
																											'success',			//*//实操结果 成功：true，失败：false
																											'code'		=> 0,	//对于失败情况，回传原因描述，请回传对应的数字 01：海外仓库内破损 02：海外仓库内丢失
																											'desc'		=> 0,	//描述
																										),
																			),
									/**
									 * 清关确认接口
									 * 场景：仓库在操作清关之后，
									 * 需要向菜鸟回传清关确认信息。
									 */
									'GATE_CLEAR_CUSTOMS'					=> array(//清关确认
																				'logisticsOrderCode',							//*//退货物流单号，简称LP号
																				'occurTime',									//*//业务发生时间，格式：yyyy-MM-dd HH:mm:ss
																				'timeZone'				=> 0,					//时区，如果东八区则值为8，西八区则为-8 默认北京时间
																				'result'				=> array(//实操结果信息
																											'success',			//*//实操结果 成功：true，失败：false
																											'code'		=> 0,	//对于失败情况，回传原因描述，请回传对应的数字 01：申报不符 02：海关扣查
																											'desc'		=> 0,	//描述
																										),
																			),
									/**
									 * 交接确认接口
									 * 场景：中转仓和干线或者配送交接包裹后需要反馈交接结果。
									 */
									'TRANSIT_WAREHOUSE_HANDOVER'			=> array(//交接确认
																				'logisticsOrderCode',							//*//退货物流单号，简称LP号
																				'occurTime',									//*//业务发生时间，格式：yyyy-MM-dd HH:mm:ss
																				'timeZone'				=> 0,					//时区，如果东八区则值为8，西八区则为-8 默认北京时间
																				'result'				=> array(//实操结果信息
																											'success',			//*//实操结果 成功：true，失败：false
																											'desc'		=> 0,	//描述
																										),
																			),
								),
);