<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => '必须被接受',
    'active_url' => '不是有效的超连结',
    'after' => '必须是 :date 之后的日期',
    'after_or_equal' => '必须是在 :date 之后或等于的日期',
    'alpha' => '只能包含字母',
    'alpha_dash' => '只能包含字母、数字、破折号和下划线',
    'alpha_num' => '只能包含字母和数字。 ',
    'array' => '必须是一个数组',
    'before' => '必须是 :date 之前的日期',
    'before_or_equal' => '必须是一个早于或等于 :date 的日期',
    'between' => [
        'numeric' => '必须介于 :min 和 :max 之间',
        'file' => '必须介于 :min 和 :max KB之间',
        'string' => '必须介于 :min 和 :max 个字符之间',
        'array' => '必须介于 :min 和 :max 之间',
    ],
    'boolean' => '字段必须为是或否',
    'confirmed' => '与确认不匹配',
    'date' => '不是有效日期',
    'date_equals' => '必须是等于 :date 的日期',
    'date_format' => '与 :format 格式不匹配',
    'different' => '和 :other 必须不同',
    'digits' => '必须是 :digits 个数字',
    'digits_between' => '必须介于 :min 和 :max 个数字之间',
    'dimensions' => '的图像尺寸无效',
    'distinct' => '字段具有重复值',
    'email' => '必须是有效的电子邮件地址',
    'ends_with' => '必须以下列之一结束: :values',
    'exists' => '所选的 无效',
    'file' => '必须是一个文件',
    'filled' => '字段必须有一个值',
    'gt' => [
        'numeric' => '必须大于 :value',
        'file' => '必须大于 :value KB',
        'string' => '必须介于 :min 和 :max 个字符之间',
        'array' => '必须有多个 :value 项',
    ],
    'gte' => [
        'numeric' => '必须大于或等于 :value',
        'file' => '必须大于或等于 :value KB',
        'string' => '必须大于或等于 :value 字符',
        'array' => '必须有 :value 项或更多项',
    ],
    'image' => '必须是图像',
    'in' => '所选的 无效',
    'in_array' => ':other 中不存在 字段',
    'integer' => '必须是整数',
    'ip' => '必须是有效的 IP 地址',
    'ipv4' => '必须是有效的 IPv4 地址',
    'ipv6' => '必须是有效的 IPv6 地址',
    'json' => '必须是有效的 JSON 字符串',
    'lt' => [
        'numeric' => '必须小于 :value',
        'file' => '必须小于 :value KB',
        'string' => '必须小于 :value 个字符',
        'array' => '必须少于 :value 项',
    ],
    'lte' => [
        'numeric' => '必须小于或等于 :value',
        'file' => '必须小于或等于 :value KB',
        'string' => '必须小于或等于 :value 个字符',
        'array' => '不能超过 :value 项',
    ],
    'max' => [
        'numeric' => '不能大于:max',
        'file' => '不能大于 :max KB',
        'string' => '不能大于 :max 个字符',
        'array' => '不能超过 :max 项',
    ],
    'mimes' => '必须是一个类型为 :values 的文件',
    'mimetypes' => '必须是一个类型为 :values 的文件',
    'min' => [
        'numeric' => '必须至少为:min',
        'file' => '必须至少为 :min KB',
        'string' => '必须至少是 :min 个字符',
        'array' => '必须至少有 :min 项',
    ],
    'not_in' => '所选的 无效',
    'not_regex' => '格式无效',
    'numeric' => '必须是一个数字',
    'password' => '密码不正确',
    'present' => '字段必须存在',
    'regex' => '格式无效',
    'required' => '需要 字段',
    'required_if' => ':当 :other 是 :value 时， 字段是必需的',
    'required_unless' => '字段是必需的，除非 :other 在 :values 中',
    'required_with' => '当 :values 存在时， 字段是必需的',
    'required_with_all' => '当 :values 存在时， 字段是必需的',
    'required_without' => '当 :values 不存在时， 字段是必需的',
    'required_without_all' => '当 :values 都不存在时， 字段是必需的',
    'same' => '和 :other 必须匹配。 ',
    'size' => [
        'numeric' => '必须是 :size',
        'file' => '必须是 :size KB',
        'string' => '必须是 :size 个字符',
        'array' => '必须包含 :size 项',
    ],
    'starts_with' => '必须以下列之一开头：:values',
    'string' => '必须是字符串',
    'timezone' => '必须是有效的区域。 ',
    'unique' => '已经被占用',
    'uploaded' => '上传失败',
    'url' => '格式无效',
    'uuid' => '必须是有效的 UUID',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => '自定义信息',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
