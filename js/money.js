		// 弹窗广告,不需要则删除该段代码
		layer.open({
			type: 1,
			area: ['310px', '450px'], //宽高
			content: '<div style="text-align: center;"><br><img src="https://img.w6wg.cn/i/2022/07/15/jwbmjm.jpg" style="width:80%;margin-bottom:15px;"><br></div>',
			title: '支付宝扫码领红包',
			btn: ['关闭'],
			btnAlign: 'c',
			shade: 0,
			btn1: function () {
				layer.closeAll();
			}
		});