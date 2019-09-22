(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[6],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/pages/Overview.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/pages/Overview.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _focus_ui_src_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../focus-ui/src/components */ "./resources/focus-ui/src/components/index.js");
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(source, true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(source).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }



/* harmony default export */ __webpack_exports__["default"] = ({
  /**
   * The child components.
   */
  components: {
    Card: _focus_ui_src_components__WEBPACK_IMPORTED_MODULE_1__["Card"],
    Page: _focus_ui_src_components__WEBPACK_IMPORTED_MODULE_1__["Page"],
    EmptyState: _focus_ui_src_components__WEBPACK_IMPORTED_MODULE_1__["EmptyState"],
    ResourceList: _focus_ui_src_components__WEBPACK_IMPORTED_MODULE_1__["ResourceList"],
    ResourceListItem: _focus_ui_src_components__WEBPACK_IMPORTED_MODULE_1__["ResourceListItem"]
  },

  /**
   * The page's meta-info.
   */
  metaInfo: {
    title: 'Pages'
  },
  data: function data() {
    return {
      loadingPages: false
    };
  },
  computed: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapGetters"])({
    pages: 'page/pages'
  })),
  mounted: function mounted() {
    this.initializeComponentState();
  },
  methods: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_0__["mapActions"])({
    fetchPages: 'page/fetchPages'
  }), {
    initializeComponentState: function initializeComponentState() {
      var _this = this;

      this.loadingPages = true;
      this.fetchPages().then(function () {
        _this.loadingPages = false;
      });
    }
  })
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/pages/Overview.vue?vue&type=template&id=7f88b32d&":
/*!************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/pages/Overview.vue?vue&type=template&id=7f88b32d& ***!
  \************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("Page", { attrs: { title: "Pages" } }, [
    _vm.loadingPages ? _c("div", [_vm._v("\n    loading...\n  ")]) : _vm._e(),
    _vm._v(" "),
    !_vm.loadingPages
      ? _c(
          "div",
          [
            !_vm.pages
              ? _c(
                  "EmptyState",
                  {
                    attrs: {
                      image: "http://pagie.local:13833/img/upload-assets.svg",
                      action: { content: "Add transfer" },
                      heading: "Manage your inventory transfers"
                    }
                  },
                  [
                    _c("p", [
                      _vm._v(
                        "Track and receive your incoming inventory from suppliers."
                      )
                    ])
                  ]
                )
              : _vm._e(),
            _vm._v(" "),
            _vm.pages
              ? _c(
                  "Card",
                  [
                    _c("ResourceList", {
                      attrs: {
                        selectable: "",
                        "resource-name": { singular: "page", plural: "pages" },
                        items: _vm.pages
                      },
                      scopedSlots: _vm._u(
                        [
                          {
                            key: "default",
                            fn: function(item) {
                              return [
                                _c(
                                  "ResourceListItem",
                                  _vm._b(
                                    {},
                                    "ResourceListItem",
                                    Object.assign({}, item),
                                    false
                                  ),
                                  [
                                    _vm._v(
                                      "\n            " +
                                        _vm._s(item) +
                                        "\n          "
                                    )
                                  ]
                                )
                              ]
                            }
                          }
                        ],
                        null,
                        false,
                        5698970
                      )
                    })
                  ],
                  1
                )
              : _vm._e()
          ],
          1
        )
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/pages/Overview.vue":
/*!***********************************************!*\
  !*** ./resources/js/pages/pages/Overview.vue ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Overview_vue_vue_type_template_id_7f88b32d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Overview.vue?vue&type=template&id=7f88b32d& */ "./resources/js/pages/pages/Overview.vue?vue&type=template&id=7f88b32d&");
/* harmony import */ var _Overview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Overview.vue?vue&type=script&lang=js& */ "./resources/js/pages/pages/Overview.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Overview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Overview_vue_vue_type_template_id_7f88b32d___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Overview_vue_vue_type_template_id_7f88b32d___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/pages/Overview.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/pages/Overview.vue?vue&type=script&lang=js&":
/*!************************************************************************!*\
  !*** ./resources/js/pages/pages/Overview.vue?vue&type=script&lang=js& ***!
  \************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Overview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Overview.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/pages/Overview.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Overview_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/pages/Overview.vue?vue&type=template&id=7f88b32d&":
/*!******************************************************************************!*\
  !*** ./resources/js/pages/pages/Overview.vue?vue&type=template&id=7f88b32d& ***!
  \******************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Overview_vue_vue_type_template_id_7f88b32d___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Overview.vue?vue&type=template&id=7f88b32d& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/pages/Overview.vue?vue&type=template&id=7f88b32d&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Overview_vue_vue_type_template_id_7f88b32d___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Overview_vue_vue_type_template_id_7f88b32d___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);