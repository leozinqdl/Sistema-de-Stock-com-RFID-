CtrlSite = {
  //abrir o menu
  CtrlOpenMenu: function () {
    $(".header_menu_opacity").slideDown().css("display", "block");
  },

  CtrlNotificacoes: function () {
    $(".open_relatorio").click(function () {
      $(".open_relatorio")
        .not(this)
        .next(".sistema_pendencia_notificacoes_table")
        .slideUp();
      $(this).next(".sistema_pendencia_notificacoes_table").slideToggle();
    });
  },

  //abrir o menu de cadastro, lançamentos e financeiro
  CtrlMenuIdHeader: function () {
    $("li.header_menu_container_acesso_rapido").click(function () {
      MenuId = $(this).attr("id");
      switch (MenuId) {
        case "cadastro":
          $("#menu_id_cadastro").slideToggle();
          $(".menu_options_itens").hide();

          break;
        case "lancamentos":
          $("#menu_id_lancamento").slideToggle();
          $(".menu_options_itens").hide();

          break;
        case "relatorios":
          $("#menu_id_relatorios").slideToggle();
          $(".menu_options_itens").hide();

          break;
      }
    });
  },

  //controlador principal do menu
  CtrlMenu: function () {
    // if (jQuery("#header").length > 0) {
    //   MinSizeWindow = 3840; //4k aqui para fazer com q o menu desapeca na barra de rolagem
    //   widthWindow = parseInt($(window).width());
    //   if (MinSizeWindow >= widthWindow) {
    //     heightmenu = $("#header").height();
    //     $(window).scroll(function () {
    //       if ($(window).scrollTop() >= heightmenu) {
    //         //alert('maior');
    //         $("#header").slideUp();
    //       } else {
    //         //alert('menor');
    //         $("#header").slideDown();
    //       }
    //     });
    //   }
    // }

    // $(window).resize(function () {
    //   if (jQuery("#header").length > 0) {
    //     MinSizeWindowR = 480;
    //     widthWindowR = 0;
    //     widthWindowR = parseInt($(window).width());
    //     if (MinSizeWindowR >= widthWindowR) {
    //       heightmenu = $("#header").height();
    //       $(window).scroll(function () {
    //         if ($(window).scrollTop() >= heightmenu) {
    //           //alert('maior');
    //           $("#header").slideUp();
    //         } else {
    //           //alert('menor');
    //           $("#header").slideDown();
    //         }
    //       });
    //     } else {
    //       return;
    //     }
    //   }
    // });
    return;
  },

  //control submenu
  openOption: function (obj) {
    indexDiv = $(obj).index() + 1;
    indexText = $(obj).text();
    switch (indexDiv) {
      case indexDiv:
        $(".menu_options").toggleClass("submenu");
        $(".menu-option-group").slideUp();
        $(
          '<li class="menu-option-group__close">' +
            indexText +
            '<div class="close-itens" title="Fechar" >X</div></li>'
        ).insertAfter(".menu-option-group");
        $(".item" + indexDiv).velocity("transition.bounceDownIn", {
          stagger: 0,
          display: "inline-block",
        });
        break;
    }
  },

  openOptionClose: function () {
    classClose = $(".menu_options").attr("class");
    alert(classClose);
    if (classClose == "menu_options submenu") {
      $(".menu-option-group__close").velocity("transition.bounceUpOut");
      $(".menu_options_itens:visible").velocity("transition.bounceUpOut", {
        stagger: 0,
        complete: function () {
          $(".menu-option-group").slideDown(150);
        },
      });
      $(".menu_options").removeClass("submenu");
    } else {
      alert("here");
      $(this).slideUp();
    }
  },

  //funcao de fechamento do menu
  CtrlCloseMenu: function () {
    $(".header_menu_opacity").click(function () {
      $(".header_menu_opacity").slideUp();
    });
    $(".header_menu_container").click(function (e) {
      e.stopPropagation();
      classClose = $(this).attr("class");
    });
    $(".menu_options").click(function (e) {
      e.stopPropagation();
      classClose = $(this).attr("class");
      if (classClose == "menu_options submenu") {
        $(".menu-option-group__close").velocity("transition.bounceUpOut");
        $(".menu_options_itens:visible").velocity("transition.bounceUpOut", {
          stagger: 0,
          complete: function () {
            $(".menu-option-group").slideDown(150);
          },
        });
        $(".menu_options").removeClass("submenu");
      } else {
        $(this).slideUp();
      }
    });

    $(".menu_options_itens").click(function (e) {
      e.stopPropagation();
    });
    $(".menu-option-group__close").on("click", function (e) {
      e.stopPropagation();
    });
    $(".menu_options_title").click(function (e) {
      e.stopPropagation();
    });
    $(".menu-option-group__item").click(function (e) {
      e.stopPropagation();
    });
    $(".close-itens").click(function (e) {
      e.stopPropagation();
    });
  },

  closeQr: function () {
    $(".qr-code-menu").hide();
  },
  minimizeAjax: function (obj) {
    openCloseTable = $(obj).attr("class");
    if (openCloseTable == "bt-fechar__minimizar") {
      $(obj).parent().parent().find("table, fieldset, form, button").hide();
      $(".pesquisa_action").hide();
      $(obj).addClass("open").empty().text("+");
    } else {
      $(obj).parent().parent().find("table, fieldset, form, button").show();
      $(".pesquisa_action").show();
      $(obj).removeClass("open").empty().text("-");
    }
  },
  closeAjax: function (obj) {
    $(obj).parent().parent().parent().remove();
  },

  classificationCloseAll: function () {
    $("#span_classification_list").empty();
  },
};

$(document).ready(function () {
  CtrlSite.CtrlNotificacoes();
  CtrlSite.CtrlMenuIdHeader();
  CtrlSite.CtrlMenu();
  CtrlSite.CtrlCloseMenu();
  CtrlSite.minimizeAjax();
});
