jQuery.extend(jQuery.validator.messages, {
required: "必填项，不能为空",
remote: "请检查输入的值是否正确",
email: "请输入正确格式的Email地址",
url: "请输入合法的网址",
date: "请输入合法的日期",
dateISO: "请输入合法的日期 (ISO).",
number: "请输入合法的数字",
digits: "只能输入整数",
creditcard: "请输入合法的信用卡号",
equalTo: "请再次输入相同的值",
accept: "请输入拥有合法后缀名的字符串",
maxlength: jQuery.validator.format("请输入一个长度最多是 {0} 的字符串"),
minlength: jQuery.validator.format("请输入一个长度最少是 {0} 的字符串"),
rangelength: jQuery.validator.format("请输入一个长度介于 {0} 和 {1} 之间的字符串"),
range: jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
max: jQuery.validator.format("请输入一个最大为 {0} 的值"),
min: jQuery.validator.format("请输入一个最小为 {0} 的值")
});