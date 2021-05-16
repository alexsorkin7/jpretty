<?php
namespace Also;

class Pretty {
    public $string = "<style>
        [als-pointer] {cursor: pointer;}
        [als-open]::before {content: '\\25BC'}
        [als-close]::before {content: '\\25B6';}
        [als-close]::after{content:\"{..}\"}
        [als-list-show] {display:block;margin-left: 20px;}
        [als-list-hide] {display:none;}
        [als-key] {font-weight:700;}
    </style>
    <script>
    function change(dom) {
        if(dom.children[0].getAttribute('als-open') !== null) {
            dom.children[0].removeAttribute('als-open')
            dom.children[1].removeAttribute('als-list-show')
            
            dom.children[0].setAttribute('als-close','')
            dom.children[1].setAttribute('als-list-hide','')
        } else if(dom.children[0].getAttribute('als-close') !== null) {
            dom.children[0].removeAttribute('als-close')
            dom.children[1].removeAttribute('als-list-hide')
            
            dom.children[0].setAttribute('als-open','')
            dom.children[1].setAttribute('als-list-show','')
        }
    }
    </script>
    ";

    function __construct($array) {
        $this->string = $this->pretty($array,$this->string);
    }

    public function run() {
        return $this->string;
    }

    public function pretty($array,$string) {
        foreach ($array as $key => $value) {
            if(gettype($value) == 'string') {
                $string .= "<div>&nbsp;&nbsp;&nbsp; <span als-key>$key</span>:$value</div>";
            } else if(gettype($value) == 'array') {
                $string .= '<div>
                <span als-close onclick="change(this.parentNode);" als-pointer>
                    <span als-key>'.$key.'</span>:
                </span>
                <div als-list-hide> ';
                $string = $this->pretty($value,$string);
                $string .= '</div></div>';
            }
        }
        return $string;
    }
}
?>

