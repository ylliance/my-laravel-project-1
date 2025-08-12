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

    'accepted' => '必須被接受',
    'active_url' => '不是有效的超連結',
    'after' => '必須是 :date 之後的日期',
    'after_or_equal' => '必須是在 :date 之後或等於的日期',
    'alpha' => '只能包含字母',
    'alpha_dash' => '只能包含字母、數字、破折號和下劃線',
    'alpha_num' => '只能包含字母和數字。',
    'array' => '必須是一個數組',
    'before' => '必須是 :date 之前的日期',
    'before_or_equal' => '必須是一個早於或等於 :date 的日期',
    'between' => [
        'numeric' => '必須介於 :min 和 :max 之間',
        'file' => '必須介於 :min 和 :max KB之間',
        'string' => '必須介於 :min 和 :max 個字符之間',
        'array' => '必須介於 :min 和 :max 之間',
    ],
    'boolean' => '字段必須為是或否',
    'confirmed' => '與確認不匹配',
    'date' => '不是有效日期',
    'date_equals' => '必須是等於 :date 的日期',
    'date_format' => '與 :format 格式不匹配',
    'different' => '和 :other 必須不同',
    'digits' => '必須是 :digits 個數字',
    'digits_between' => '必須介於 :min 和 :max 個數字之間',
    'dimensions' => '的圖像尺寸無效',
    'distinct' => '字段具有重複值',
    'email' => '必須是有效的電子郵件地址',
    'ends_with' => '必須以下列之一結束: :values',
    'exists' => '所選的 無效',
    'file' => '必須是一個文件',
    'filled' => '字段必須有一個值',
    'gt' => [
        'numeric' => '必須大於 :value',
        'file' => '必須大於 :value KB',
        'string' => '必須介於 :min 和 :max 個字符之間',
        'array' => '必須有多個 :value 項',
    ],
    'gte' => [
        'numeric' => '必須大於或等於 :value',
        'file' => '必須大於或等於 :value KB',
        'string' => '必須大於或等於 :value 字符',
        'array' => '必須有 :value 項或更多項',
    ],
    'image' => '必須是圖像',
    'in' => '所選的 無效',
    'in_array' => ':other 中不存在 字段',
    'integer' => '必須是整數',
    'ip' => '必須是有效的 IP 地址',
    'ipv4' => '必須是有效的 IPv4 地址',
    'ipv6' => '必須是有效的 IPv6 地址',
    'json' => '必須是有效的 JSON 字符串',
    'lt' => [
        'numeric' => '必須小於 :value',
        'file' => '必須小於 :value KB',
        'string' => '必須小於 :value 個字符',
        'array' => '必須少於 :value 項',
    ],
    'lte' => [
        'numeric' => '必須小於或等於 :value',
        'file' => '必須小於或等於 :value KB',
        'string' => '必須小於或等於 :value 個字符',
        'array' => '不能超過 :value 項',
    ],
    'max' => [
        'numeric' => '不能大於:max',
        'file' => '不能大於 :max KB',
        'string' => '不能大於 :max 個字符',
        'array' => '不能超過 :max 項',
    ],
    'mimes' => '必須是一個類型為 :values 的文件',
    'mimetypes' => '必須是一個類型為 :values 的文件',
    'min' => [
        'numeric' => '必須至少為:min',
        'file' => '必須至少為 :min KB',
        'string' => '必須至少是 :min 個字符',
        'array' => '必須至少有 :min 項',
    ],
    'not_in' => '所選的 無效',
    'not_regex' => '格式無效',
    'numeric' => '必須是一個數字',
    'password' => '密碼不正確',
    'present' => '字段必須存在',
    'regex' => '格式無效',
    'required' => '需要輸入字段',
    'required_if' => ':當 :other 是 :value 時， 字段是必需的',
    'required_unless' => '字段是必需的，除非 :other 在 :values 中',
    'required_with' => '當 :values 存在時， 字段是必需的',
    'required_with_all' => '當 :values 存在時， 字段是必需的',
    'required_without' => '當 :values 不存在時， 字段是必需的',
    'required_without_all' => '當 :values 都不存在時， 字段是必需的',
    'same' => '和 :other 必須匹配。',
    'size' => [
        'numeric' => '必須是 :size',
        'file' => '必須是 :size KB',
        'string' => '必須是 :size 個字符',
        'array' => '必須包含 :size 項',
    ],
    'starts_with' => '必須以下列之一開頭：:values',
    'string' => '必須是字符串',
    'timezone' => '必須是有效的區域。',
    'unique' => '已經被佔用',
    'uploaded' => '上傳失敗',
    'url' => '格式無效',
    'uuid' => '必須是有效的 UUID',

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
            'rule-name' => '自定義信息',
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
