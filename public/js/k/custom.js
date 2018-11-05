/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
(function($,sr){
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
      var timeout;

        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args); 
                timeout = null; 
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100); 
        };
    };

    // smartresize 
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');
/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var  $BODY = $('body');
// Sidebar
$(document).ready(function() {
    var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');
    //console.log("HOLA");
    // TODO: This is some kind of easy fix, maybe we can improve this
    var setContentHeight = function () {
        // reset height        
        //console.log($('footer'));
        $RIGHT_COL.css('min-height', $(window).height());
        //$LEFT_COL.css('min-height', $(window).height());
        var bodyHeight = $BODY.outerHeight(),
            leftColHeight = $LEFT_COL.height(),
            contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;
        // normalize content
        //contentHeight -= $NAV_MENU.height();        
        console.log(contentHeight);
        $RIGHT_COL.css('min-height', contentHeight);
        //$LEFT_COL.css('min-height', $RIGHT_COL.height());
    };

    $SIDEBAR_MENU.find('a').on('click', function(ev) {

        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active active-sm');
            $('ul:first', $li).slideUp(function() {
                //console.log("HOLA");
                setContentHeight();
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active active-sm');
                $SIDEBAR_MENU.find('li ul').slideUp();
            }
            
            $li.addClass('active');

            $('ul:first', $li).slideDown(function() {
                //console.log("HOLA2");
                setContentHeight();
            });
        }
    });

    // toggle small or large menu
    /*
    $MENU_TOGGLE.on('click', function() {

        if ($BODY.hasClass('nav-md')) {
            $SIDEBAR_MENU.find('li.active ul').hide();
            $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
        } else {
            $SIDEBAR_MENU.find('li.active-sm ul').show();
            $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
        }

        $BODY.toggleClass('nav-md nav-sm');
        
        setContentHeight();
    });
    */
   
   var $SIDEBAR_MENU = $('#sidebar-menu');

  $("#menu_toggle").click(function(){
  

    if ($("BODY").hasClass('nav-md')) {
      $('.left_col').css('width','70px');
      $("SIDEBAR_MENU").find('li.active ul').hide();
      $("SIDEBAR_MENU").find('li.active').addClass('active-sm').removeClass('active');
    } 
    else {
      $('.left_col').css('width','250px');
      $("SIDEBAR_MENU").find('li.active-sm ul').show();
      $("SIDEBAR_MENU").find('li.active-sm').addClass('active').removeClass('active-sm');
    }

    $("BODY").toggleClass('nav-md nav-sm');
  });  


    // check active menu
    $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

    $SIDEBAR_MENU.find('a').filter(function () {
        return this.href == CURRENT_URL;
    })/*.parent('li').addClass('current-page').parents('ul').slideDown(function() {
        console.log("HOLA4");
        setContentHeight();
    })*/.parent().addClass('active');

    // recompute content when resizing
    $(window).smartresize(function(){  
        //console.log("HOLA5");
        setContentHeight();
    });
    //console.log("HOLA6");
    setContentHeight();

    // fixed sidebar
    if ($.fn.mCustomScrollbar) {
        $('.menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            theme: 'minimal',
            mouseWheel:{ preventDefault: true }
        });
    }
});
// /Sidebar

// Panel toolbox
$(document).ready(function() {
    $('.collapse-link').on('click', function() {
        var $BOX_PANEL = $(this).closest('.x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.x_content');
        
        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function(){
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200); 
            $BOX_PANEL.css('height', 'auto');  
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
});
// /Panel toolbox

// Tooltip
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });
});
// /Tooltip

// Progressbar
if ($(".progress .progress-bar")[0]) {
    $('.progress .progress-bar').progressbar();
}
// /Progressbar

// Switchery
$(document).ready(function() {
    if ($(".js-switch")[0]) {
        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function (html) {
            var switchery = new Switchery(html, {
                color: '#26B99A'
            });
        });
    }
});
// /Switchery

// iCheck
/*$(document).ready(function() {
    if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }
});*/
// /iCheck

// Table
$('table input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('table input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});

var checkState = '';

$('.bulk_action input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('.bulk_action input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});
$('.bulk_action input#check-all').on('ifChecked', function () {
    checkState = 'all';
    countChecked();
});
$('.bulk_action input#check-all').on('ifUnchecked', function () {
    checkState = 'none';
    countChecked();
});

function countChecked() {
    if (checkState === 'all') {
        $(".bulk_action input[name='table_records']").iCheck('check');
    }
    if (checkState === 'none') {
        $(".bulk_action input[name='table_records']").iCheck('uncheck');
    }

    var checkCount = $(".bulk_action input[name='table_records']:checked").length;

    if (checkCount) {
        $('.column-title').hide();
        $('.bulk-actions').show();
        $('.action-cnt').html(checkCount + ' Records Selected');
    } else {
        $('.column-title').show();
        $('.bulk-actions').hide();
    }
}

// Accordion
$(document).ready(function() {
    $(".expand").on("click", function () {
        $(this).next().slideToggle(200);
        $expand = $(this).find(">:first-child");

        if ($expand.text() == "+") {
            $expand.text("-");
        } else {
            $expand.text("+");
        }
    });
});

// NProgress
if (typeof NProgress != 'undefined') {
    $(document).ready(function () {
        NProgress.start();
    });

    $(window).load(function () {
        NProgress.done();
    });
}


//Grafico del reporte
/*function init_echarts() {
		
    if( typeof (echarts) === 'undefined'){ return; }
    console.log('init_echarts');


      var theme = {
      color: [
          '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
          '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
      ],

      title: {
          itemGap: 8,
          textStyle: {
              fontWeight: 'normal',
              color: '#408829'
          }
      },

      dataRange: {
          color: ['#1f610a', '#97b58d']
      },

      toolbox: {
          color: ['#408829', '#408829', '#408829', '#408829']
      },

      tooltip: {
          backgroundColor: 'rgba(0,0,0,0.5)',
          axisPointer: {
              type: 'line',
              lineStyle: {
                  color: '#408829',
                  type: 'dashed'
              },
              crossStyle: {
                  color: '#408829'
              },
              shadowStyle: {
                  color: 'rgba(200,200,200,0.3)'
              }
          }
      },

      dataZoom: {
          dataBackgroundColor: '#eee',
          fillerColor: 'rgba(64,136,41,0.2)',
          handleColor: '#408829'
      },
      grid: {
          borderWidth: 0
      },

      categoryAxis: {
          axisLine: {
              lineStyle: {
                  color: '#408829'
              }
          },
          splitLine: {
              lineStyle: {
                  color: ['#eee']
              }
          }
      },

      valueAxis: {
          axisLine: {
              lineStyle: {
                  color: '#408829'
              }
          },
          splitArea: {
              show: true,
              areaStyle: {
                  color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
              }
          },
          splitLine: {
              lineStyle: {
                  color: ['#eee']
              }
          }
      },
      timeline: {
          lineStyle: {
              color: '#408829'
          },
          controlStyle: {
              normal: {color: '#408829'},
              emphasis: {color: '#408829'}
          }
      },

      k: {
          itemStyle: {
              normal: {
                  color: '#68a54a',
                  color0: '#a9cba2',
                  lineStyle: {
                      width: 1,
                      color: '#408829',
                      color0: '#86b379'
                  }
              }
          }
      },
      map: {
          itemStyle: {
              normal: {
                  areaStyle: {
                      color: '#ddd'
                  },
                  label: {
                      textStyle: {
                          color: '#c12e34'
                      }
                  }
              },
              emphasis: {
                  areaStyle: {
                      color: '#99d2dd'
                  },
                  label: {
                      textStyle: {
                          color: '#c12e34'
                      }
                  }
              }
          }
      },
      force: {
          itemStyle: {
              normal: {
                  linkStyle: {
                      strokeColor: '#408829'
                  }
              }
          }
      },
      chord: {
          padding: 4,
          itemStyle: {
              normal: {
                  lineStyle: {
                      width: 1,
                      color: 'rgba(128, 128, 128, 0.5)'
                  },
                  chordStyle: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      }
                  }
              },
              emphasis: {
                  lineStyle: {
                      width: 1,
                      color: 'rgba(128, 128, 128, 0.5)'
                  },
                  chordStyle: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      }
                  }
              }
          }
      },
      gauge: {
          startAngle: 225,
          endAngle: -45,
          axisLine: {
              show: true,
              lineStyle: {
                  color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                  width: 8
              }
          },
          axisTick: {
              splitNumber: 10,
              length: 12,
              lineStyle: {
                  color: 'auto'
              }
          },
          axisLabel: {
              textStyle: {
                  color: 'auto'
              }
          },
          splitLine: {
              length: 18,
              lineStyle: {
                  color: 'auto'
              }
          },
          pointer: {
              length: '90%',
              color: 'auto'
          },
          title: {
              textStyle: {
                  color: '#333'
              }
          },
          detail: {
              textStyle: {
                  color: 'auto'
              }
          }
      },
      textStyle: {
          fontFamily: 'Arial, Verdana, sans-serif'
      }
    };

    //echart Bar
  
    if ($('#myfirstchart').length ){
  
      var echartBar = echarts.init(document.getElementById('myfirstchart'), theme);

      echartBar.setOption({
        title: {
          text: 'Graph title',
          subtext: 'Graph Sub-text'
        },
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['sales', 'purchases']
        },
        toolbox: {
          show: false
        },
        calculable: false,
        xAxis: [{
          type: 'category',
          data: ['1?', '2?', '3?', '4?', '5?', '6?', '7?', '8?', '9?', '10?', '11?', '12?']
        }],
        yAxis: [{
          type: 'value'
        }],
        series: [{
          name: 'sales',
          type: 'bar',
          data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
          markPoint: {
            data: [{
              type: 'max',
              name: '???'
            }, {
              type: 'min',
              name: '???'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: '???'
            }]
          }
        }, {
          name: 'purchases',
          type: 'bar',
          data: [2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
          markPoint: {
            data: [{
              name: 'sales',
              value: 182.2,
              xAxis: 7,
              yAxis: 183,
            }, {
              name: 'purchases',
              value: 2.3,
              xAxis: 11,
              yAxis: 3
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: '???'
            }]
          }
        }]
      });

    }
}*/

/* CHART - MORRIS  */
		
/*function init_morris_charts() {
			
    if( typeof (Morris) === 'undefined'){ return; }
    console.log('init_morris_charts');
    
    if ($('#graph_bar').length){ 
    
        Morris.Bar({
          element: 'graph_bar',
          data: [
            {device: 'iPhone 4', geekbench: 380},
            {device: 'iPhone 4S', geekbench: 655},
            {device: 'iPhone 3GS', geekbench: 275},
            {device: 'iPhone 5', geekbench: 1571},
            {device: 'iPhone 5S', geekbench: 655},
            {device: 'iPhone 6', geekbench: 2154},
            {device: 'iPhone 6 Plus', geekbench: 1144},
            {device: 'iPhone 6S', geekbench: 2371},
            {device: 'iPhone 6S Plus', geekbench: 1471},
            {device: 'Other', geekbench: 1371}
          ],
          xkey: 'device',
          ykeys: ['geekbench'],
          labels: ['Geekbench'],
          barRatio: 0.4,
          barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
          xLabelAngle: 35,
          hideHover: 'auto',
          resize: true
        });

    }	
    
    if ($('#graph_bar_group').length ){
    
        Morris.Bar({
          element: 'graph_bar_group',
          data: [
            {"period": "2016-10-01", "licensed": 807, "sorned": 660},
            {"period": "2016-09-30", "licensed": 1251, "sorned": 729},
            {"period": "2016-09-29", "licensed": 1769, "sorned": 1018},
            {"period": "2016-09-20", "licensed": 2246, "sorned": 1461},
            {"period": "2016-09-19", "licensed": 2657, "sorned": 1967},
            {"period": "2016-09-18", "licensed": 3148, "sorned": 2627},
            {"period": "2016-09-17", "licensed": 3471, "sorned": 3740},
            {"period": "2016-09-16", "licensed": 2871, "sorned": 2216},
            {"period": "2016-09-15", "licensed": 2401, "sorned": 1656},
            {"period": "2016-09-10", "licensed": 2115, "sorned": 1022}
          ],
          xkey: 'period',
          barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
          ykeys: ['licensed', 'sorned'],
          labels: ['Licensed', 'SORN'],
          hideHover: 'auto',
          xLabelAngle: 60,
          resize: true
        });

    }
    
    if ($('#graphx').length ){
    
        Morris.Bar({
          element: 'graphx',
          data: [
            {x: '2015 Q1', y: 2, z: 3, a: 4},
            {x: '2015 Q2', y: 3, z: 5, a: 6},
            {x: '2015 Q3', y: 4, z: 3, a: 2},
            {x: '2015 Q4', y: 2, z: 4, a: 5}
          ],
          xkey: 'x',
          ykeys: ['y', 'z', 'a'],
          barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
          hideHover: 'auto',
          labels: ['Y', 'Z', 'A'],
          resize: true
        }).on('click', function (i, row) {
            console.log(i, row);
        });

    }
    
    if ($('#graph_area').length ){
    
        Morris.Area({
          element: 'graph_area',
          data: [
            {period: '2014 Q1', iphone: 2666, ipad: null, itouch: 2647},
            {period: '2014 Q2', iphone: 2778, ipad: 2294, itouch: 2441},
            {period: '2014 Q3', iphone: 4912, ipad: 1969, itouch: 2501},
            {period: '2014 Q4', iphone: 3767, ipad: 3597, itouch: 5689},
            {period: '2015 Q1', iphone: 6810, ipad: 1914, itouch: 2293},
            {period: '2015 Q2', iphone: 5670, ipad: 4293, itouch: 1881},
            {period: '2015 Q3', iphone: 4820, ipad: 3795, itouch: 1588},
            {period: '2015 Q4', iphone: 15073, ipad: 5967, itouch: 5175},
            {period: '2016 Q1', iphone: 10687, ipad: 4460, itouch: 2028},
            {period: '2016 Q2', iphone: 8432, ipad: 5713, itouch: 1791}
          ],
          xkey: 'period',
          ykeys: ['iphone', 'ipad', 'itouch'],
          lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
          labels: ['iPhone', 'iPad', 'iPod Touch'],
          pointSize: 2,
          hideHover: 'auto',
          resize: true
        });

    }
    
    if ($('#graph_donut').length ){
    
        Morris.Donut({
          element: 'graph_donut',
          data: [
            {label: 'Jam', value: 25},
            {label: 'Frosted', value: 40},
            {label: 'Custard', value: 25},
            {label: 'Sugar', value: 10}
          ],
          colors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
          formatter: function (y) {
            return y + "%";
          },
          resize: true
        });

    }
    
    if ($('#graph_line').length ){
    
        Morris.Line({
          element: 'graph_line',
          xkey: 'year',
          ykeys: ['value'],
          labels: ['Value'],
          hideHover: 'auto',
          lineColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
          data: [
            {year: '2012', value: 20},
            {year: '2013', value: 10},
            {year: '2014', value: 5},
            {year: '2015', value: 5},
            {year: '2016', value: 20}
          ],
          resize: true
        });

        $MENU_TOGGLE.on('click', function() {
          $(window).resize();
        });
    
    }
    
};*/