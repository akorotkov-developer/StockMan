;
$(document).foundation();
//begin of yandex api
(function(global) {
  function setupAsync(e) {
    ym.env = e;
    for (var t = 0, n = ym.envCallbacks.length; t < n; t++) ym.envCallbacks[t](e);
    ym.modules.define("system.nextTick", [], function(e) {
        var t = function() {
          var e = [],
            t = function(t) {
              return 1 === e.push(t)
            },
            n = function() {
              var t = e,
                n = 0,
                r = e.length;
              for (e = []; n < r;) t[n++]()
            };
          if ("object" == typeof process && process.nextTick) return function(e) {
            t(e) && process.nextTick(n)
          };
          if (global.setImmediate) return function(e) {
            t(e) && global.setImmediate(n)
          };
          if (global.postMessage && !global.opera) {
            var r = !0;
            if (global.attachEvent) {
              var o = function() {
                r = !1
              };
              global.attachEvent("onmessage", o), global.postMessage("__checkAsync", "*"), global.detachEvent("onmessage", o)
            }
            if (r) {
              var i = "__ym" + +new Date,
                s = function(e) {
                  e.data === i && (e.stopPropagation && e.stopPropagation(), n())
                };
              return global.addEventListener ? global.addEventListener("message", s, !0) : global.attachEvent("onmessage", s),
                function(e) {
                  t(e) && global.postMessage(i, "*")
                }
            }
          }
          var a = global.document;
          if ("onreadystatechange" in a.createElement("script")) {
            var u = a.getElementsByTagName("head")[0],
              c = function() {
                var e = a.createElement("script");
                e.onreadystatechange = function() {
                  e.parentNode.removeChild(e), e = e.onreadystatechange = null, n()
                }, u.appendChild(e)
              };
            return function(e) {
              t(e) && c()
            }
          }
          return function(e) {
            t(e) && setTimeout(n, 0)
          }
        }();
        e(t)
      }), ym.modules.define("util.extend", ["util.objectKeys"], function(e, t) {
        function n(e) {
          if (ym.env.debug && !e) throw new Error("util.extend: не передан параметр target");
          for (var t = 1, n = arguments.length; t < n; t++) {
            var r = arguments[t];
            if (r)
              for (var o in r) r.hasOwnProperty(o) && (e[o] = r[o])
          }
          return e
        }

        function r(e) {
          if (ym.env.debug && !e) throw new Error("util.extend: не передан параметр target");
          for (var n = 1, r = arguments.length; n < r; n++) {
            var o = arguments[n];
            if (o)
              for (var i = t(o), s = 0, a = i.length; s < a; s++) e[i[s]] = o[i[s]]
          }
          return e
        }
        e("function" == typeof Object.keys ? r : n)
      }), ym.modules.define("util.objectKeys", [], function(e) {
        var t = "function" == typeof Object.keys ? Object.keys : function(e) {
          var t = [];
          for (var n in e) e.hasOwnProperty(n) && t.push(n);
          return t
        };
        e(function(e) {
          var n, r = typeof e;
          if ("object" != r && "function" != r) throw new TypeError("Object.keys called on non-object");
          return n = t(e)
        })
      }), ym.modules.define("system.mergeImports", [], function(e) {
        function t(e, t, n) {
          if (t) {
            var r = e;
            t = t.split(".");
            for (var o, i = 0, s = t.length - 1; i < s; i++) t[i] && (r = r[o = t[i]] || (r[o] = {}));
            return r[t[s]] = n, r[t[s]]
          }
          return n
        }

        function n(e, t) {
          return e[2] - t[2]
        }

        function r(e) {
          return 0 === e.indexOf("package.")
        }

        function o(e, n, r) {
          for (var o = [], i = {}, s = 0, a = n.length; s < a; ++s) {
            var u = r[s].__package;
            if (u)
              for (var c = 0; c < u.length; ++c) i[u[c][0]] || (t(e, u[c][0], u[c][1]), o.push([u[c][0], u[c][1]]), i[u[c][0]] = 1);
            else t(e, n[s], r[s]), i[n[s]] || (o.push([n[s], r[s]]), i[n[s]] = 1)
          }
          return e.__package = o, e
        }

        function i(e, i, s, a) {
          var u = [],
            c = r(e);
          if (c) return o(i, s, a);
          for (var l = 0, f = s.length; l < f; ++l) u.push([s[l], l, s[l].length]);
          u.sort(n);
          for (var l = 0, f = u.length; l < f; ++l) {
            var d = u[l][1],
              p = s[d];
            if (r(p))
              for (var m = a[d].__package, h = 0; h < m.length; ++h) t(i, m[h][0], m[h][1]);
            else t(i, p, a[d])
          }
          return i
        }
        e({
          isPackage: r,
          joinImports: i,
          createNS: t
        })
      }), ym.modules.require(["system.ModuleLoader"], function(e) {
        new e(ym.project.initialMap, ym.env.server).defineAll()
      }),
      function(e) {
        function t() {
          var e = {};
          arguments.length && (1 != arguments.length || "object" != typeof arguments[0] || arguments[0].length ? "function" != typeof arguments[0] ? (e.require = "string" == typeof arguments[0] ? [arguments[0]] : arguments[0], e.successCallback = arguments[1], e.errorCallback = arguments[2] && "function" == typeof arguments[2] ? arguments[2] : null, e.context = arguments[2] && "object" == typeof arguments[2] ? arguments[2] : arguments[3]) : (e.successCallback = arguments[0], e.errorCallback = arguments[1] && "function" == typeof arguments[1] ? arguments[1] : null, e.context = arguments[1] && "object" == typeof arguments[1] ? arguments[1] : arguments[2]) : e = arguments[0]);
          var t = e.require ? ym.modules.require(e.require) : u.resolve();
          return u.all([n(), t, l, c, p]).spread(function(t, n) {
            return a(n) && t.joinImports("package.ymaps", ym.ns, e.require, n), e.successCallback && ym.modules.nextTick(function() {
              e.successCallback.call(e.context, ym.ns)
            }), ym.ns
          }).fail(function(t) {
            return e.errorCallback && ym.modules.nextTick(function() {
              e.errorCallback.call(e.context, t)
            }), u.reject(t)
          })
        }

        function n() {
          return m || (m = ym.modules.require(["system.mergeImports"]).spread(function(e) {
            return e
          })), m
        }

        function r() {
          var e = ym.project.preload;
          if (!a(e)) return u.resolve();
          var t = ym.modules.require(e);
          return u.all([n(), t]).spread(function(t, n) {
            a(n) && t.joinImports("package.ymaps", ym.ns, e, n)
          })
        }

        function o() {
          var e = ym.env.preload,
            t = e.load && e.load.length > 0 && e.load.split(","),
            r = t ? ym.modules.require(t) : u.resolve();
          return e.onError && r.fail(function(t) {
            ym.modules.nextTick(function() {
              i(0, e.onError, t)
            })
          }), u.all([n(), r, c]).spread(function(n, r) {
            a(r) && n.joinImports("package.ymaps", ym.ns, t, r), e.onLoad && ym.modules.nextTick(function() {
              i(0, e.onLoad, ym.ns)
            })
          })
        }

        function i(t, n, r) {
          var o = s(e, n);
          o ? o.method.call(o.context, r) : window.setTimeout(function() {
            i(++t, n, r)
          }, Math.pow(2, t))
        }

        function s(e, t) {
          var n = e;
          t = t.split(".");
          for (var r = 0, o = t.length - 1; r < o; r++)
            if (n = n[t[r]], !n) return;
          return {
            method: n[t[o]],
            context: n
          }
        }

        function a(e) {
          return e && e.length
        }
        var u = ym.vow,
          c = r(),
          l = o(),
          f = "complete" == document.readyState,
          d = u.defer(),
          p = f ? u.resolve() : d.promise(),
          m = null,
          h = function() {
            f || (f = !0, d.resolve())
          };
        f || (document.addEventListener ? (document.addEventListener("DOMContentLoaded", h, !1), window.addEventListener("load", h, !1)) : document.attachEvent && window.attachEvent("onload", h)), ym.ns.ready = t
      }(this), ym.modules.define("system.ModuleLoader", ["system.moduleLoader.createLoadFunction", "system.moduleLoader.executeInSandbox", "system.nextTick"], function(e, t, n, r) {
        function o(e, n) {
          this._map = e, this._modulesInfo = this._parseMap(e), this._waitForNextTick = !1, this._load = t(n, this._modulesInfo.byName)
        }
        var i = {
          NOT_RESOLVED: "NOT_RESOLVED",
          IN_RESOLVING: "IN_RESOLVING",
          RESOLVED: "RESOLVED"
        };
        o.prototype.defineAll = function() {
          for (var e = 0, t = this._map.length; e < t; e++) {
            var n = this._map[e][0];
            ym.modules.isDefined(n) || ym.modules.define(this.buildDefinition(n))
          }
        }, o.prototype.buildDefinition = function(e) {
          var t = this,
            n = this._modulesInfo.byName[e],
            r = this._fetchDeps(n.name, n.deps),
            o = {
              name: n.name,
              depends: r,
              declaration: function(e) {
                t._queueLoad(this.name, {
                  context: this,
                  arguments: Array.prototype.slice.call(arguments, 0)
                })
              }
            };
          return n.key && (o.key = n.key.split(","), o.storage = n.storage), n.dynamicDepends && (o.dynamicDepends = n.dynamicDepends), o
        }, o.prototype._parseMap = function(e) {
          for (var t = {
              byName: {},
              byAlias: {}
            }, n = 0, r = e.length; n < r; n++) {
            var o = e[n],
              s = {
                name: o[0],
                alias: o[1],
                deps: o[2],
                key: o[3],
                storage: o[4],
                dynamicDepends: o[5],
                state: i.NOT_RESOLVED
              };
            t.byName[s.name] = s, t.byAlias[s.alias] = s
          }
          return t
        }, o.prototype._fetchDeps = function(e, t) {
          if ("function" == typeof t) return t.call({
            name: e
          }, ym);
          for (var n = []; t.length;) {
            var r = "";
            "=" == t.charAt(0) ? (r = t.match(/=(.+?)=/)[1], n.push(r), t = t.substring(r.length + 2)) : (r = t.substring(0, 2), n.push(this._modulesInfo.byAlias[r].name), t = t.substring(2))
          }
          return n
        }, o.prototype._splitAliases = function(e) {
          for (var t = [], n = 0, r = e.length; n < r; n += 2) t.push(e.substr(n, 2));
          return t
        }, o.prototype._queueLoad = function(e, t) {
          var o = this;
          this._waitForNextTick || (this._waitForNextTick = !0, r(function() {
            o._loadAll()
          })), this._load(e, function(r) {
            n(e, r, t)
          })
        }, o.prototype._loadAll = function() {
          for (var e = 0, t = this._map.length; e < t; ++e) {
            var n = this._map[e][0],
              r = this._modulesInfo.byName[n];
            r.state == i.NOT_RESOLVED && ym.modules.getState(n) == i.IN_RESOLVING && (r.state = i.IN_RESOLVING, this._load(n))
          }
          this._waitForNextTick = !1
        }, e(o)
      }), ym.modules.define("system.moduleLoader.executeInSandbox", ["system.mergeImports", "util.extend"], function(e, t, n) {
        function r(e, t, r) {
          var i = new o(e, r.context, r.arguments),
            s = n({}, ym, {
              modules: i
            });
          t.call(r.context, s, s), i.execute()
        }

        function o(e, t, n) {
          this._name = e, this._context = t, this._arguments = n, this._provides = []
        }
        o.prototype.requireSync = function(e) {
          return ym.modules.requireSync(e)
        }, o.prototype.defineSync = function(e, t) {
          return ym.modules.defineSync(e, t)
        }, o.prototype.define = function(e, t, n) {
          this._executed ? ym.modules.define.apply(ym.modules, arguments) : "object" == typeof e ? this._holdingFn = e.declaration : "function" != typeof n && "function" == typeof t ? this._holdingFn = t : this._holdingFn = n
        }, o.prototype.getDefinition = function(e) {
          return ym.modules.getDefinition(e)
        }, o.prototype.isDefined = function(e) {
          return ym.modules.isDefined(e)
        }, o.prototype.require = function(e, t, n, r) {
          return 3 == arguments.length && "function" != typeof n ? ym.modules.require(e, t, n) : ym.modules.require(e, t, n, r)
        }, o.prototype.importImages = function(e) {
          var t = [ym.env.server.url, ym.env.server.path.replace(/\/$/, ""), "images", this._name.replace(/\./g, "_") + "_"].join("/");
          return {
            get: function(n) {
              return /\.\w+$/.test(n) || (n += e[n].src.match(/\.\w+$/)[0]), t + n
            }
          }
        }, o.prototype.execute = function() {
          this._executed = !0, this._holdingFn && this._holdingFn.apply(this._context, this._arguments)
        }, o.prototype.providePackage = ym.modules.providePackage, e(r)
      }), ym.modules.define("system.moduleLoader.createLoadFunction", ["system.nextTick"], function(e, t) {
        function n(e, n) {
          function o(e, n, r) {
            if (m[e]) return void n.call(r, m[e], e);
            l || (l = !0, t(c));
            var o = d[e];
            o ? o.callback.push([n, r]) : (d[e] = o = {
              moduleName: e,
              callback: [
                [n, r]
              ]
            }, f.push(o))
          }

          function i(e, t) {
            window[t] = void 0;
            try {
              window[t] = null, delete window[t]
            } catch (n) {}
            window.setTimeout(function() {
              try {
                e && e.parentNode && e.parentNode.removeChild(e)
              } catch (t) {}
            }, 0)
          }

          function s(t, n, o, s) {
            function a() {
              setTimeout(function() {
                if (!c) {
                  window.console && console.error("ymaps: script not loaded");
                  for (var e = 0, t = f.length; e < t; ++e) f[e][1] && f[e][1]()
                }
              }, 60)
            }
            var u = 0,
              c = !1,
              l = window[n] = function(e) {
                for (var t = 0, n = f.length; t < n; ++t) f[t][0](e);
                f = null
              },
              f = l.listeners = [
                [function() {
                  c = !0, clearTimeout(u), i(d, n)
                }], s
              ],
              d = document.createElement("script"),
              p = e.url + "/combine.js?load=" + t + "&callback_prefix=" + o,
              m = e.params;
            m && (m.mode && (p += "&mode=" + encodeURIComponent(m.mode)), m.namespace && (p += "&namespace=" + encodeURIComponent(m.namespace))), d.charset = "utf-8", d.async = !0, d.src = p, d.onreadystatechange = function() {
              "complete" != this.readyState && "loaded" != this.readyState || a()
            }, d.onload = d.onerror = a, document.getElementsByTagName("head")[0].appendChild(d), u = setTimeout(s[1], r)
          }

          function a(e, t, n, r) {
            var o = t + "_" + e;
            window[o] ? window[o].listeners.push([n, r]) : s(e, o, t, [n, r])
          }

          function u(e) {
            function t(e) {
              p--;
              for (var t = [], n = 0, r = e.length; n < r; ++n) {
                var o = h[e[n][0]],
                  i = e[n][1];
                if (o) {
                  for (var s = 0, a = o.callback.length; s < a; ++s) o.callback[s][0] && o.callback[s][0].call(o.callback[s][1], i, o.moduleName);
                  m[o.moduleName] = i, t.push(o.moduleName), delete d[o.moduleName], delete h[e[n][0]]
                }
              }
            }

            function n(e) {
              try {
                t(e)
              } catch (n) {
                r(), setTimeout(function() {
                  throw n
                }, 1)
              }
            }

            function r() {
              p--;
              for (var t = 0, n = e.length; t < n; ++t) {
                var r = h[e[t]];
                r && delete d[r.moduleName], delete h[o[t]]
              }
            }
            var o = e.join("");
            p++;
            var i = ym.project.namespace + ym.project.jsonpPrefix + "_loader";
            1 == e.length && (i += h[e[0]].moduleName), a(o, i, ym.env.debug ? t : n, r)
          }

          function c() {
            var e = ym.project.loadLimit,
              r = Math.min(e, f.length),
              o = 0,
              i = [];
            if (r) {
              for (f = f.sort(function(e, t) {
                  return e.moduleName.localeCompare(t.moduleName)
                }), o = 0; o < r; o++) {
                var s = n[f[o].moduleName].alias;
                h[s] = f[o], i.push(s)
              }
              u(i)
            }
            f.length && r < f.length ? (f = f.slice(r), t(c)) : (f = [], l = !1)
          }
          var l = !1,
            f = [],
            d = {},
            p = 0,
            m = {},
            h = {};
          return o
        }
        var r = 3e4;
        e(n)
      })
  }
  var ym = {
    project: {
      preload: ["package.system"],
      namespace: "ymaps",
      jsonpPrefix: "",
      loadLimit: 500
    },
    ns: {},
    env: {},
    envCallbacks: []
  };
  ! function() {
    var e = {
        exports: {}
      },
      t = e.exports;
    ! function(n) {
      var r, o = {
          NOT_RESOLVED: "NOT_RESOLVED",
          IN_RESOLVING: "IN_RESOLVING",
          RESOLVED: "RESOLVED"
        },
        i = function() {
          var e = {
              trackCircularDependencies: !0,
              allowMultipleDeclarations: !0
            },
            t = {},
            p = !1,
            m = [],
            h = function(e, n, i) {
              i || (i = n, n = []);
              var s = t[e];
              s || (s = t[e] = {
                name: e,
                decl: r
              }), s.decl = {
                name: e,
                prev: s.decl,
                fn: i,
                state: o.NOT_RESOLVED,
                deps: n,
                dependents: [],
                exports: r
              }
            },
            v = function(e, t, r) {
              "string" == typeof e && (e = [e]), p || (p = !0, d(w)), m.push({
                deps: e,
                cb: function(e, o) {
                  o ? (r || s)(o) : t.apply(n, e)
                }
              })
            },
            y = function(e) {
              var n = t[e];
              return n ? o[n.decl.state] : "NOT_DEFINED"
            },
            g = function(e) {
              var n = t[e];
              return n ? n.decl.deps : null
            },
            _ = function(e) {
              return !!t[e]
            },
            b = function(t) {
              for (var n in t) t.hasOwnProperty(n) && (e[n] = t[n])
            },
            w = function() {
              p = !1, E()
            },
            E = function() {
              var e, t = m,
                n = 0;
              for (m = []; e = t[n++];) k(null, e.deps, [], e.cb)
            },
            k = function(e, n, r, o) {
              var i = n.length;
              i || o([]);
              for (var s, u, c = [], l = function(e, t) {
                  if (t) return void o(null, t);
                  if (!--i) {
                    for (var n, r = [], s = 0; n = c[s++];) r.push(n.exports);
                    o(r)
                  }
                }, f = 0, d = i; f < d;) {
                if (s = n[f++], "string" == typeof s) {
                  if (!t[s]) return void o(null, a(s, e));
                  u = t[s].decl
                } else u = s;
                c.push(u), j(u, r, l)
              }
            },
            j = function(t, r, i) {
              if (t.state === o.RESOLVED) return void i(t.exports);
              if (t.state === o.IN_RESOLVING) return void(e.trackCircularDependencies && f(t, r) ? i(null, u(t, r)) : t.dependents.push(i));
              if (t.dependents.push(i), t.prev && !e.allowMultipleDeclarations) return void D(t, l(t));
              e.trackCircularDependencies && (r = r.slice()).push(t);
              var s = !1,
                a = t.prev ? t.deps.concat([t.prev]) : t.deps;
              t.state = o.IN_RESOLVING, k(t, a, r, function(e, r) {
                return r ? void D(t, r) : (e.unshift(function(e, n) {
                  return s ? void i(null, c(t)) : (s = !0, void(n ? D(t, n) : x(t, e)))
                }), void t.fn.apply({
                  name: t.name,
                  deps: t.deps,
                  global: n
                }, e))
              })
            },
            x = function(e, t) {
              e.exports = t, e.state = o.RESOLVED;
              for (var n, i = 0; n = e.dependents[i++];) n(t);
              e.dependents = r
            },
            D = function(e, t) {
              e.state = o.NOT_RESOLVED;
              for (var n, r = 0; n = e.dependents[r++];) n(null, t);
              e.dependents = []
            };
          return {
            create: i,
            define: h,
            require: v,
            getState: y,
            getDependencies: g,
            isDefined: _,
            setOptions: b,
            flush: w,
            nextTick: d
          }
        },
        s = function(e) {
          d(function() {
            throw e
          })
        },
        a = function(e, t) {
          return Error(t ? 'Module "' + t.name + '": can\'t resolve dependence "' + e + '"' : 'Required module "' + e + "\" can't be resolved")
        },
        u = function(e, t) {
          for (var n, r = [], o = 0; n = t[o++];) r.push(n.name);
          return r.push(e.name), Error('Circular dependence has been detected: "' + r.join(" -> ") + '"')
        },
        c = function(e) {
          return Error('Declaration of module "' + e.name + '" has already been provided')
        },
        l = function(e) {
          return Error('Multiple declarations of module "' + e.name + '" have been detected')
        },
        f = function(e, t) {
          for (var n, r = 0; n = t[r++];)
            if (e === n) return !0;
          return !1
        },
        d = function() {
          var e = [],
            t = function(t) {
              return 1 === e.push(t)
            },
            r = function() {
              var t = e,
                n = 0,
                r = e.length;
              for (e = []; n < r;) t[n++]()
            };
          if ("object" == typeof process && process.nextTick) return function(e) {
            t(e) && process.nextTick(r)
          };
          if (n.setImmediate) return function(e) {
            t(e) && n.setImmediate(r)
          };
          if (n.postMessage && !n.opera) {
            var o = !0;
            if (n.attachEvent) {
              var i = function() {
                o = !1
              };
              n.attachEvent("onmessage", i), n.postMessage("__checkAsync", "*"), n.detachEvent("onmessage", i)
            }
            if (o) {
              var s = "__modules" + +new Date,
                a = function(e) {
                  e.data === s && (e.stopPropagation && e.stopPropagation(), r())
                };
              return n.addEventListener ? n.addEventListener("message", a, !0) : n.attachEvent("onmessage", a),
                function(e) {
                  t(e) && n.postMessage(s, "*")
                }
            }
          }
          var u = n.document;
          if ("onreadystatechange" in u.createElement("script")) {
            var c = u.getElementsByTagName("head")[0],
              l = function() {
                var e = u.createElement("script");
                e.onreadystatechange = function() {
                  e.parentNode.removeChild(e), e = e.onreadystatechange = null, r()
                }, c.appendChild(e)
              };
            return function(e) {
              t(e) && l()
            }
          }
          return function(e) {
            t(e) && setTimeout(r, 0)
          }
        }();
      "object" == typeof t ? e.exports = i() : n.modules = i()
    }(this), ym.modules = e.exports
  }(), ym.modules.setOptions({
      trackCircularDependencies: !0,
      allowMultipleDeclarations: !1
    }), ym.ns.modules = ym.modules,
    function() {
      var e, t, n = {
        exports: {}
      };
      n.exports;
      ! function(r) {
        var o, i = function() {
            var e = [],
              t = function(t) {
                return 1 === e.push(t)
              },
              n = function() {
                var t = e,
                  n = 0,
                  r = e.length;
                for (e = []; n < r;) t[n++]()
              };
            if ("function" == typeof setImmediate) return function(e) {
              t(e) && setImmediate(n)
            };
            if ("object" == typeof process && process.nextTick) return function(e) {
              t(e) && process.nextTick(n)
            };
            if (r.postMessage) {
              var o = !0;
              if (r.attachEvent) {
                var i = function() {
                  o = !1
                };
                r.attachEvent("onmessage", i), r.postMessage("__checkAsync", "*"), r.detachEvent("onmessage", i)
              }
              if (o) {
                var s = "__promise" + +new Date,
                  a = function(e) {
                    e.data === s && (e.stopPropagation && e.stopPropagation(), n())
                  };
                return r.addEventListener ? r.addEventListener("message", a, !0) : r.attachEvent("onmessage", a),
                  function(e) {
                    t(e) && r.postMessage(s, "*")
                  }
              }
            }
            var u = r.document;
            if ("onreadystatechange" in u.createElement("script")) {
              var c = function() {
                var e = u.createElement("script");
                e.onreadystatechange = function() {
                  e.parentNode.removeChild(e), e = e.onreadystatechange = null, n()
                }, (u.documentElement || u.body).appendChild(e)
              };
              return function(e) {
                t(e) && c()
              }
            }
            return function(e) {
              t(e) && setTimeout(n, 0)
            }
          }(),
          s = function(e, t, n) {
            if (w.debug) n ? e.call(n) : e();
            else try {
              n ? e.call(n) : e()
            } catch (r) {
              return n ? t.call(n, r) : t(r), !1
            }
            return !0
          },
          a = function(e) {
            i(function() {
              throw e
            })
          },
          u = function(e) {
            return "function" == typeof e
          },
          c = function(e) {
            return null !== e && "object" == typeof e
          },
          l = Object.prototype.toString,
          f = Array.isArray || function(e) {
            return "[object Array]" === l.call(e)
          },
          d = function(e) {
            for (var t = [], n = 0, r = e.length; n < r;) t.push(n++);
            return t
          },
          p = Object.keys || function(e) {
            var t = [];
            for (var n in e) e.hasOwnProperty(n) && t.push(n);
            return t
          },
          m = function(e) {
            var t = function(t) {
              this.name = e, this.message = t
            };
            return t.prototype = new Error, t
          },
          h = function(e, t) {
            return function(n) {
              e.call(this, n, t)
            }
          },
          v = function() {
            this._promise = new g
          };
        v.prototype = {
          promise: function() {
            return this._promise
          },
          resolve: function(e) {
            this._promise.isResolved() || this._promise._resolve(e)
          },
          reject: function(e) {
            this._promise.isResolved() || (w.isPromise(e) ? (e = e.then(function(e) {
              var t = w.defer();
              return t.reject(e), t.promise()
            }), this._promise._resolve(e)) : this._promise._reject(e))
          },
          notify: function(e) {
            this._promise.isResolved() || this._promise._notify(e)
          }
        };
        var y = {
            PENDING: 0,
            RESOLVED: 1,
            FULFILLED: 2,
            REJECTED: 3
          },
          g = function(e) {
            if (this._value = o, this._status = y.PENDING, this._fulfilledCallbacks = [], this._rejectedCallbacks = [], this._progressCallbacks = [], e) {
              var t = this,
                n = e.length;
              e(function(e) {
                t.isResolved() || t._resolve(e)
              }, n > 1 ? function(e) {
                t.isResolved() || t._reject(e)
              } : o, n > 2 ? function(e) {
                t.isResolved() || t._notify(e)
              } : o)
            }
          };
        g.prototype = {
          valueOf: function() {
            return this._value
          },
          isResolved: function() {
            return this._status !== y.PENDING
          },
          isFulfilled: function() {
            return this._status === y.FULFILLED
          },
          isRejected: function() {
            return this._status === y.REJECTED
          },
          then: function(e, t, n, r) {
            var o = new v;
            return this._addCallbacks(o, e, t, n, r), o.promise()
          },
          "catch": function(e, t) {
            return this.then(o, e, t)
          },
          fail: function(e, t) {
            return this.then(o, e, t)
          },
          always: function(e, t) {
            var n = this,
              r = function() {
                return e.call(this, n)
              };
            return this.then(r, r, t)
          },
          progress: function(e, t) {
            return this.then(o, o, e, t)
          },
          spread: function(e, t, n) {
            return this.then(function(t) {
              return e.apply(this, t)
            }, t, n)
          },
          done: function(e, t, n, r) {
            this.then(e, t, n, r).fail(a)
          },
          delay: function(e) {
            var t, n = this.then(function(n) {
              var r = new v;
              return t = setTimeout(function() {
                r.resolve(n)
              }, e), r.promise()
            });
            return n.always(function() {
              clearTimeout(t)
            }), n
          },
          timeout: function(e) {
            var t = new v,
              n = setTimeout(function() {
                t.reject(new w.TimedOutError("timed out"))
              }, e);
            return this.then(function(e) {
              t.resolve(e)
            }, function(e) {
              t.reject(e)
            }), t.promise().always(function() {
              clearTimeout(n)
            }), t.promise()
          },
          _vow: !0,
          _resolve: function(e) {
            if (!(this._status > y.RESOLVED)) {
              if (e === this) return void this._reject(TypeError("Can't resolve promise with itself"));
              if (this._status = y.RESOLVED, e && e._vow) return void(e.isFulfilled() ? this._fulfill(e.valueOf()) : e.isRejected() ? this._reject(e.valueOf()) : e.then(this._fulfill, this._reject, this._notify, this));
              if (c(e) || u(e)) {
                var t, n = s(function() {
                  t = e.then
                }, function(e) {
                  this._reject(e)
                }, this);
                if (!n) return;
                if (u(t)) {
                  var r = this,
                    o = !1;
                  return void s(function() {
                    t.call(e, function(e) {
                      o || (o = !0, r._resolve(e))
                    }, function(e) {
                      o || (o = !0, r._reject(e))
                    }, function(e) {
                      r._notify(e)
                    })
                  }, function(e) {
                    o || this._reject(e)
                  }, this)
                }
              }
              this._fulfill(e)
            }
          },
          _fulfill: function(e) {
            this._status > y.RESOLVED || (this._status = y.FULFILLED, this._value = e, this._callCallbacks(this._fulfilledCallbacks, e), this._fulfilledCallbacks = this._rejectedCallbacks = this._progressCallbacks = o)
          },
          _reject: function(e) {
            this._status > y.RESOLVED || (this._status = y.REJECTED, this._value = e, this._callCallbacks(this._rejectedCallbacks, e), this._fulfilledCallbacks = this._rejectedCallbacks = this._progressCallbacks = o)
          },
          _notify: function(e) {
            this._callCallbacks(this._progressCallbacks, e)
          },
          _addCallbacks: function(e, t, n, r, i) {
            n && !u(n) ? (i = n, n = o) : r && !u(r) && (i = r, r = o);
            var s;
            this.isRejected() || (s = {
              defer: e,
              fn: u(t) ? t : o,
              ctx: i
            }, this.isFulfilled() ? this._callCallbacks([s], this._value) : this._fulfilledCallbacks.push(s)), this.isFulfilled() || (s = {
              defer: e,
              fn: n,
              ctx: i
            }, this.isRejected() ? this._callCallbacks([s], this._value) : this._rejectedCallbacks.push(s)), this._status <= y.RESOLVED && this._progressCallbacks.push({
              defer: e,
              fn: r,
              ctx: i
            })
          },
          _callCallbacks: function(e, t) {
            var n = e.length;
            if (n) {
              var r = this.isResolved(),
                o = this.isFulfilled();
              i(function() {
                for (var i, a, u, c = 0; c < n;)
                  if (i = e[c++], a = i.defer, u = i.fn) {
                    var l, f = i.ctx,
                      d = s(function() {
                        l = f ? u.call(f, t) : u(t)
                      }, function(e) {
                        a.reject(e)
                      });
                    if (!d) continue;
                    r ? a.resolve(l) : a.notify(l)
                  } else r ? o ? a.resolve(t) : a.reject(t) : a.notify(t)
              })
            }
          }
        };
        var _ = {
          cast: function(e) {
            return w.cast(e)
          },
          all: function(e) {
            return w.all(e)
          },
          race: function(e) {
            return w.anyResolved(e)
          },
          resolve: function(e) {
            return w.resolve(e)
          },
          reject: function(e) {
            return w.reject(e)
          }
        };
        for (var b in _) _.hasOwnProperty(b) && (g[b] = _[b]);
        var w = {
            debug: !1,
            Deferred: v,
            Promise: g,
            defer: function() {
              return new v
            },
            when: function(e, t, n, r, o) {
              return w.cast(e).then(t, n, r, o)
            },
            fail: function(e, t, n) {
              return w.when(e, o, t, n)
            },
            always: function(e, t, n) {
              return w.when(e).always(t, n)
            },
            progress: function(e, t, n) {
              return w.when(e).progress(t, n)
            },
            spread: function(e, t, n, r) {
              return w.when(e).spread(t, n, r)
            },
            done: function(e, t, n, r, o) {
              w.when(e).done(t, n, r, o)
            },
            isPromise: function(e) {
              return c(e) && u(e.then)
            },
            cast: function(e) {
              return w.isPromise(e) ? e : w.resolve(e)
            },
            valueOf: function(e) {
              return e && u(e.valueOf) ? e.valueOf() : e
            },
            isFulfilled: function(e) {
              return !e || !u(e.isFulfilled) || e.isFulfilled()
            },
            isRejected: function(e) {
              return !(!e || !u(e.isRejected)) && e.isRejected()
            },
            isResolved: function(e) {
              return !e || !u(e.isResolved) || e.isResolved()
            },
            resolve: function(e) {
              var t = w.defer();
              return t.resolve(e), t.promise()
            },
            fulfill: function(e) {
              var t = w.defer(),
                n = t.promise();
              return t.resolve(e), n.isFulfilled() ? n : n.then(null, function(e) {
                return e
              })
            },
            reject: function(e) {
              var t = w.defer();
              return t.reject(e), t.promise()
            },
            invoke: function(e, t) {
              var n, o, i = Math.max(arguments.length - 1, 0);
              if (i) {
                n = Array(i);
                for (var a = 0; a < i;) n[a++] = arguments[a]
              }
              return s(function() {
                o = w.resolve(n ? e.apply(r, n) : e.call(r))
              }, function(e) {
                o = w.reject(e)
              }), o
            },
            all: function(e) {
              var t = new v,
                n = f(e),
                r = n ? d(e) : p(e),
                o = r.length,
                i = n ? [] : {};
              if (!o) return t.resolve(i), t.promise();
              var s = o;
              return w._forEach(e, function(e, n) {
                i[r[n]] = e, --s || t.resolve(i)
              }, t.reject, t.notify, t, r), t.promise()
            },
            allResolved: function(e) {
              var t = new v,
                n = f(e),
                r = n ? d(e) : p(e),
                o = r.length,
                i = n ? [] : {};
              if (!o) return t.resolve(i), t.promise();
              var s = function() {
                --o || t.resolve(e)
              };
              return w._forEach(e, s, s, t.notify, t, r), t.promise()
            },
            allPatiently: function(e) {
              return w.allResolved(e).then(function() {
                var t, n, r, o, i = f(e),
                  s = i ? d(e) : p(e),
                  a = s.length,
                  u = 0;
                if (!a) return i ? [] : {};
                for (; u < a;) r = s[u++], o = e[r], w.isRejected(o) ? (t || (t = i ? [] : {}), i ? t.push(o.valueOf()) : t[r] = o.valueOf()) : t || ((n || (n = i ? [] : {}))[r] = w.valueOf(o));
                return t ? w.reject(t) : n
              })
            },
            any: function(e) {
              var t = new v,
                n = e.length;
              if (!n) return t.reject(Error()), t.promise();
              var r, o = 0;
              return w._forEach(e, t.resolve, function(e) {
                o || (r = e), ++o === n && t.reject(r)
              }, t.notify, t), t.promise()
            },
            anyResolved: function(e) {
              var t = new v,
                n = e.length;
              return n ? (w._forEach(e, t.resolve, t.reject, t.notify, t), t.promise()) : (t.reject(Error()), t.promise())
            },
            delay: function(e, t) {
              return w.resolve(e).delay(t)
            },
            timeout: function(e, t) {
              return w.resolve(e).timeout(t)
            },
            _forEach: function(e, t, n, r, o, i) {
              for (var s = i ? i.length : e.length, a = 0; a < s;) w.when(e[i ? i[a] : a], h(t, a), n, r, o), ++a
            },
            TimedOutError: m("TimedOut")
          },
          E = !0;
        "object" == typeof n && "object" == typeof n.exports && (n.exports = w, E = !1), "object" == typeof t && (t.define("vow", function(e) {
          e(w)
        }), E = !1), "function" == typeof e && (e(function(e, t, n) {
          n.exports = w
        }), E = !1), E && (r.vow = w)
      }(this), ym.vow = n.exports
    }(), ym.modules.define("vow", [], function(e) {
      e(ym.vow)
    }), ym.ns.vow = ym.vow;
  var _backup_modules = this.modules;
  ! function(e, t, n) {
    function r(e) {
      this.entry = e
    }

    function o() {
      this._fallbacks = [], this._retrieversData = {}
    }
    var i, s = 10,
      a = ym.vow,
      u = Array.prototype.slice,
      c = {},
      l = {},
      f = function(e, t) {
        return new Error('The key "' + t + '" isn\'t declared in "' + e + '" storage.')
      },
      d = function(e) {
        return new Error('The dynamic depend "' + e + '" not found.')
      },
      p = function(e) {
        return new Error("Undefined module `" + e + "` with no matching fallback.")
      };
    i = {
      fallbacks: new o,
      define: function(e, n, r, o) {
        var s, a, u, c = this;
        if ("function" == typeof n && "function" != typeof r) r = n, o = r, n = [];
        else if ("object" == typeof e) {
          var f = e;
          e = f.name, n = f.depends, r = f.declaration, o = f.context, u = f.dynamicDepends, s = f.storage, a = f.key
        }
        if (l.hasOwnProperty(e) || (l[e] = {
            name: e
          }), "function" == typeof n && (n = n.call({
            name: e
          }, ym)), l[e].callback = r, l[e].context = o, s && a) {
          if ("string" != typeof a)
            for (var d = 0, p = a.length; d < p; d++) this._createKeyStorageRef(e, a[d], s);
          else this._createKeyStorageRef(e, a, s);
          l[e].key = a, l[e].storage = s
        }
        u && (l[e].dynamicDepends = u);
        var m = i._createPatchedCallback(e);
        if (null != n) {
          for (var h = [], d = 0, p = n.length; d < p; d++) h[d] = this._processModuleName(n[d]);
          h = this.fallbacks.addRetrievers(h), this.nextTick(function() {
            c.fallbacks.removeRetrievers(t.getDependencies(e))
          }), t.define(e, h, m)
        } else t.define(e, m);
        return this
      },
      require: function(r, o, s, c, l) {
        var f = a.defer(),
          d = f.promise(),
          p = n;
        if (3 == arguments.length && "function" != typeof s) c = s, s = null;
        else if (!r.hasOwnProperty("length") && "object" == typeof r) {
          var m = r;
          r = m.modules, o = m.successCallback, s = m.errorCallback, c = m.context, m.hasOwnProperty("data") && (p = m.data)
        }
        r = "string" != typeof r && r.hasOwnProperty("length") ? r : [r];
        var h = r.length,
          v = this._processModuleList(r, p);
        return r = v.list, ym.env.debug && !l && this.watchResolving(r), v.error ? f.reject(v.error) : t.require(r, function() {
          var t = u.call(arguments, arguments.length - h);
          f.resolve(t), o && o.apply(c || e, t)
        }, function(e) {
          l ? f.reject(e) : i.fallbacks.retrieve(r).then(function() {
            f.resolve(i.require(r, o, s, c, !0))
          }).fail(function(e) {
            f.reject(e)
          })
        }), s && !l && d.fail(function(t) {
          s.call(c || e, t)
        }), d
      },
      defineSync: function(e, t) {
        var n, r;
        if ("object" == typeof e) {
          var o = e;
          t = o.module, n = o.storage, r = o.key, e = o.name
        }
        if (i.isDefined(e)) {
          var s = l[e];
          s.name = e, s.module = t, s.callback = function(e) {
            e(t)
          }, s.context = null
        } else l[e] = {
          name: e,
          module: t
        }, i.define(e, function(e) {
          e(t)
        });
        r && n && (l[e].key = r, l[e].storage = n, this._createKeyStorageRef(e, r, n))
      },
      requireSync: function(e, t) {
        var n = this.getDefinition(e),
          r = null;
        return n && (r = n.getModuleSync.apply(n, u.call(arguments, 1))), r
      },
      providePackage: function(e) {
        var t = this,
          n = Array.prototype.slice.call(arguments, 1);
        i.require(["system.mergeImports"]).spread(function(r) {
          e(r.joinImports(t.name, {}, t.deps, n))
        })
      },
      getDefinition: function(e) {
        var t = null;
        return e = this._processModuleName(e), l.hasOwnProperty(e) && (t = new r(l[e])), t
      },
      getState: function(e) {
        return t.getState(this._processModuleName(e))
      },
      isDefined: function(e) {
        return t.isDefined(this._processModuleName(e))
      },
      setOptions: function(e) {
        return t.setOptions(e)
      },
      flush: function() {
        return t.flush()
      },
      nextTick: function(e) {
        return t.nextTick(e)
      },
      watchResolving: function(e) {
        if ("object" == typeof console && "function" == typeof console.warn) {
          var t = this;
          "undefined" == typeof this._failCounter && (this._failCounter = 0), setTimeout(function() {
            0 == t._failCounter && setTimeout(function() {
              t._failCounter = 0
            }, 150);
            for (var n = 0, r = e.length; n < r; n++)
              if ("RESOLVED" != t.getState(e[n])) {
                if (t._failCounter++, 5 == t._failCounter) setTimeout(function() {
                  console.warn("Timeout: Totally " + t._failCounter + " modules were required but not resolved within " + s + " sec.")
                }, 100);
                else if (t._failCounter > 5) continue;
                console.warn("Timeout: Module `" + e[n] + "` was required but is still " + t.getState(e[n]) + " within " + s + " sec.")
              }
          }, 1e3 * s)
        }
      },
      _createPatchedCallback: function(e) {
        var t = this;
        return function() {
          var n = l[e],
            r = u.call(arguments, 0),
            o = n.callback,
            s = n.context;
          ym.env.debug && t.watchResolving([e]), r[0] = i._patchProvideFunction(r[0], e), o && o.apply(s || this, r)
        }
      },
      _processModuleList: function(e, n, r) {
        for (var o = {
            list: []
          }, i = 0, s = e.length; i < s; i++) {
          var a = this._processModuleName(e[i]);
          if (!a) {
            o.error = f(e[i].storage, e[i].key);
            break
          }
          if ("undefined" != typeof n) {
            var u = t.getDependencies(a),
              c = l[a];
            if (u) {
              var d = this._processModuleList(u, n, !0);
              if (d.error) {
                o.error = d.error;
                break
              }
              o.list = o.list.concat(d.list)
            }
            if (c && c.dynamicDepends) {
              var p = [];
              for (var m in c.dynamicDepends) {
                var h = c.dynamicDepends[m](n);
                this._isDepend(h) && p.push(h)
              }
              var d = this._processModuleList(p, n);
              if (d.error) {
                o.error = d.error;
                break
              }
              o.list = o.list.concat(d.list)
            }
            this.fallbacks.isRetriever(a) && this.fallbacks.addRetrieverData(a, n)
          }
          r || o.list.push(a)
        }
        return o
      },
      _createKeyStorageRef: function(e, t, n) {
        c.hasOwnProperty(n) || (c[n] = {}), c[n][t] = e
      },
      _processModuleName: function(e) {
        if ("string" != typeof e) {
          var t = e.storage;
          e = c.hasOwnProperty(t) ? c[t][e.key] || null : null
        }
        return e
      },
      _patchProvideFunction: function(e, t) {
        var r = function(n, r) {
          var o = l[t];
          o.module = n, e(n, r), r || (delete o.callback, delete o.context)
        };
        return r.provide = r, r.dynamicDepends = {
          getValue: function(e, n) {
            var r = a.defer(),
              o = l[t];
            if (o.dynamicDepends && o.dynamicDepends.hasOwnProperty(e)) {
              var s = o.dynamicDepends[e](n);
              r.resolve(i._isDepend(s) ? i.getDefinition(s).getModule(n) : [s])
            } else r.reject(d(e));
            return r.promise()
          },
          getValueSync: function(e, r) {
            var o = n,
              s = l[t];
            if (s.dynamicDepends && s.dynamicDepends.hasOwnProperty(e)) {
              var a = s.dynamicDepends[e](r);
              o = i._isDepend(a) ? i.getDefinition(a).getModuleSync(r) : a
            }
            return o
          }
        }, r
      },
      _isDepend: function(e) {
        return "string" == typeof e || e && e.key && e.storage
      }
    }, r.prototype.getModuleKey = function() {
      return this.entry.key
    }, r.prototype.getModuleStorage = function() {
      return this.entry.storage
    }, r.prototype.getModuleName = function() {
      return this.entry.name
    }, r.prototype.getModuleSync = function(e) {
      if (arguments.length > 0) {
        var t = this.entry.dynamicDepends;
        for (var r in t) {
          var o = t[r](e);
          if (i._isDepend(o) && !i.getDefinition(o).getModuleSync(e)) return n
        }
      }
      return this.entry.module
    }, r.prototype.getModule = function(e) {
      var t = {
        modules: [this.entry.name]
      };
      return e && (t.data = e), i.require(t)
    };
    var m = "_retriever@";
    o.prototype.register = function(e, t) {
      e && "*" != e ? this._fallbacks.unshift({
        filter: e,
        func: t
      }) : this._fallbacks.push({
        filter: e || "*",
        func: t
      })
    }, o.prototype.retrieve = function(e) {
      "string" == typeof e && (e = [e]);
      for (var t = [], n = 0, r = e.length; n < r; n++) {
        var o = a.defer(),
          s = e[n];
        if (t[n] = o.promise(), i.isDefined(s)) o.resolve(!0);
        else {
          var u = this.find(s);
          if (!u) {
            o.reject(p(s));
            break
          }
          o.resolve(u.func(s, u.filter))
        }
      }
      return a.all(t)
    }, o.prototype.find = function(e) {
      for (var t = 0, n = this._fallbacks.length; t < n; t++) {
        var r = this._fallbacks[t].filter;
        if ("*" === r) return this._fallbacks[t];
        if ("function" == typeof r && r(e)) return this._fallbacks[t];
        if (e.match(r)) return this._fallbacks[t]
      }
      return null
    }, o.prototype.addRetrievers = function(e) {
      for (var t, n, r = [], o = 0, s = e.length; o < s; o++) t = e[o], i.isDefined(t) ? r.push(t) : (n = m + t, r.push(n), i.isDefined(n) || this._defineRetriever(n));
      return r
    }, o.prototype.removeRetrievers = function(e) {
      for (var t, n = 0, r = e.length; n < r; n++) this.isRetriever(e[n]) && !this._retrieversData[e[n]] && (t = e[n].replace(m, ""), i.isDefined(t) && (e[n] = t))
    }, o.prototype.isRetriever = function(e) {
      return 0 === e.indexOf(m)
    }, o.prototype.addRetrieverData = function(e, t) {
      this._retrieversData[e] || (this._retrieversData[e] = []), this._retrieversData[e].push(t)
    }, o.prototype._defineRetriever = function(e) {
      var t = this;
      i.define(e, [], function(e) {
        var n = this.name.replace(m, "");
        t.retrieve(n).then(function() {
          return t._requireAfterRetrieve(n)
        }).spread(e).fail(e)
      })
    }, o.prototype._requireAfterRetrieve = function(e) {
      var t = this._retrieversData[m + e];
      if (!t) return i.require(e);
      for (var n = [], r = 0, o = t.length; r < o; r++) n.push(i.require({
        modules: [e],
        data: t[r]
      }));
      return a.all(n).then(function(e) {
        return e[0]
      })
    }, e.modules = i
  }(this, ym.modules), ym.modules = this.modules, this.modules = _backup_modules, _backup_modules = void 0, ym.ns.modules = ym.modules, ym.project.initialMap = [],
    function(e) {
      function t(e, t) {
        return r || (r = n(t))
      }

      function n(e) {
        return e = encodeURIComponent(e), ym.modules.require(["util.jsonp", "util.querystring", "util.extend", "system.ModuleLoader"]).spread(function(t, n, r, o) {
          var i = ym.env.server,
            s = i.url + "/map.js",
            a = {
              filter: e,
              mode: i.params.mode,
              version: i.version
            },
            u = "ym_map_fallback";
          if (!i.params.short_jsonp_padding) {
            var c = r({
                url: s
              }, a),
              l = n.stringify(c, "_", "=", {
                encodeURIComponent: function(e) {
                  return e
                }
              });
            u += "_" + l.replace(/[:\/\.\?\&\\]/g, "_")
          }
          return t({
            url: s,
            requestParams: a,
            paddingKey: u
          }).then(function(e) {
            new o(e, i).defineAll()
          })
        })
      }
      ym.modules.define("util.id", [], function(e) {
        var t = new function() {
          function e() {
            return (++n).toString()
          }
          var t = ("id_" + +new Date + Math.round(1e4 * Math.random())).toString(),
            n = Math.round(1e4 * Math.random());
          this.prefix = function() {
            return t
          }, this.gen = e, this.get = function(n) {
            return n === window ? t : n[t] || (n[t] = e())
          }
        };
        e(t)
      }), ym.modules.define("util.querystring", [], function(e) {
        function t(e) {
          return "[object Array]" === Object.prototype.toString.call(e)
        }
        e({
          parse: function(e, n, r, o) {
            n = n || "&", r = r || "=", o = o || {};
            for (var i, s, a, u = o.decodeURIComponent || decodeURIComponent, c = {}, l = e.split(n), f = 0; f < l.length; ++f) i = l[f].split(r), s = u(i[0]), a = u(i.slice(1).join(r)), t(c[s]) ? c[s].push(a) : c.hasOwnProperty(s) ? c[s] = [c[s], a] : c[s] = a;
            return c
          },
          stringify: function(e, n, r, o) {
            n = n || "&", r = r || "=", o = o || {};
            var i, s, a = o.encodeURIComponent || encodeURIComponent,
              u = [];
            for (i in e)
              if (e.hasOwnProperty(i))
                if (s = e[i], t(s))
                  if (o.joinArrays) u.push(a(i) + r + a(s.join(",")));
                  else
                    for (var c = 0; c < s.length; ++c) "undefined" != typeof s[c] && u.push(a(i) + r + a(s[c]));
            else "undefined" != typeof s && u.push(a(i) + r + a(s));
            return u.join(n)
          }
        })
      }), ym.modules.define("util.script", [], function(e) {
        var t = document.getElementsByTagName("head")[0];
        e({
          create: function(e, n) {
            var r = document.createElement("script");
            return r.charset = n || "utf-8", r.src = e, setTimeout(function() {
              t.insertBefore(r, t.firstChild)
            }, 0), r
          }
        })
      }), ym.modules.define("util.jsonp", ["util.id", "util.querystring", "util.script"], function(e, t, n, r) {
        function o(e) {
          return o.handler ? o.handler(e, i) : i(e)
        }

        function i(e) {
          var o, i, a = "undefined" == typeof e.checkResponse || e.checkResponse,
            f = e.responseFieldName || "response",
            d = e.requestParams ? "&" + n.stringify(e.requestParams, null, null, {
              joinArrays: !0
            }) : "",
            p = ym.vow.defer(),
            m = p.promise(),
            h = e.timeout || 3e4,
            v = setTimeout(function() {
              p.reject(c)
            }, h),
            y = function() {
              s(i, o), clearTimeout(v), v = null
            };
          if (!e.padding) {
            if (o = e.paddingKey || t.prefix() + t.gen(), "function" == typeof window[o] && window[o].promise) return window[o].promise;
            u(o), window[o] = function(e) {
              if (a) {
                var t = !e || e.error || e[f] && e[f].error;
                t ? p.reject(t) : p.resolve(e && e[f] || e)
              } else p.resolve(e)
            }, window[o].promise = m
          }
          var g = e.url + (/\?/.test(e.url) ? "&" : "?") + (e.paramName || "callback") + "=" + (e.padding || o) + (e.noCache ? "&_=" + Math.floor(1e7 * Math.random()) : "") + d;
          if (e.postprocessUrl)
            if ("function" == typeof e.postprocessUrl) g = e.postprocessUrl(g);
            else
              for (; e.postprocessUrl.length;) g = e.postprocessUrl.shift()(g);
          return i = r.create(g), i.onerror = function() {
            p.reject(l)
          }, m.always(y), m
        }

        function s(e, t) {
          t && a(t), setTimeout(function() {
            e && e.parentNode && e.parentNode.removeChild(e)
          }, 0)
        }

        function a(e) {
          window[e] = f, d[e] = setTimeout(function() {
            window[e] = void 0;
            try {
              delete window[e]
            } catch (t) {}
          }, 500)
        }

        function u(e) {
          d[e] && (clearTimeout(d[e]), d[e] = null)
        }
        var c = {
            message: "timeoutExceeded"
          },
          l = {
            message: "scriptError"
          },
          f = function() {},
          d = {};
        e(o)
      });
      var r = null;
      ym.modules.fallbacks.register("*", t)
    }(this),
    function(e) {
      function t(e, t, n) {
        if (t) {
          var r = e;
          t = t.split(".");
          for (var o, i = 0, s = t.length - 1; i < s; i++) t[i] && (r = r[o = t[i]] || (r[o] = {}));
          return r[t[s]] = n, r[t[s]]
        }
        return n
      }
      ym.project.namespace && ("function" == typeof setupAsync ? ym.envCallbacks.push(function(n) {
        n.namespace !== !1 && t(e, n.namespace || ym.project.namespace, ym.ns)
      }) : t(e, ym.project.namespace, ym.ns))
    }(this), ym.envCallbacks.push(function(e) {
      e.enterprise && ym.project.preload.push("package.private.yandex.enterprise")
    }), ym.envCallbacks.push(function(e) {
      e.development && (ym.vow.debug = !0)
    }),
    function() {
      function e(t) {
        for (var n in t) t.hasOwnProperty(n) && ("string" == typeof t[n] ? "/" == t[n].charAt(0) && (t[n] = "https:" + t[n]) : e(t[n]))
      }
      ym.envCallbacks.push(function(t) {
        "/" == t.server.url.charAt(0) && (t.server.url = "https:" + t.server.url), e(t.hosts)
      })
    }(), ym.ns.load = function(e, t, n, r) {
      var o = ym.ns.ready;
      return "function" == typeof e ? t ? o(["package.full"], e, t) : o(["package.full"], e) : ("string" == typeof e && (e = [e]), o.apply(this, arguments))
    }, ym.modules.define("system.browser", ["system.supports.graphics"], function(e, t) {
      var n = ym.env.browser;
      n.documentMode = document.documentMode, n.isIE = "MSIE" == n.name || "IEMobile" == n.name, n.oldIE = "MSIE" == n.name && n.documentMode < 9, n.isEdge = "Edge" == n.engine, n.isChromium = n.base && "chromium" == n.base.toLocaleLowerCase(), n.isSafari = "Safari" == n.name;
      var r = "Edge" == n.engine || "MSIE" == n.name && n.documentMode >= 10 && n.osVersion > 6.1 || "IEMobile" == n.name && n.engineVersion >= 6;
      r ? n.eventMapper = "pointer" : n.oldIE ? n.eventMapper = "oldIE" : n.eventMapper = "touchMouse", n.androidBrokenBuild = "AndroidBrowser" == n.name && "534.30" == n.engineVersion;
      var o = window.devicePixelRatio || screen.deviceXDPI && screen.deviceXDPI / 96 || 1;
      n.oldIE ? n.graphicsRenderEngine = "vml" : !t.hasCanvas() || "MSIE" == n.name || "IEMobile" == n.name || "Android" == n.osFamily && n.engine && "gecko" == n.engine.toLocaleLowerCase() || o > 1 && o < 2 ? n.graphicsRenderEngine = "svg" : n.graphicsRenderEngine = "canvas", n.transformTransition = "Android" == n.osFamily || "iOS" == n.osFamily || "MSIE" == n.name && n.documentMode >= 10 || n.base && "chromium" == n.base.toLocaleLowerCase(), n.css3DTransform = "WebKit" == n.engine && !("Android" == n.osFamily && parseFloat(n.osVersion) < 3) || "Gecko" == n.engine && parseInt(n.engineVersion.split(".")[0]) >= 10, n.unsupported = "OperaMini" == n.name, n.platform = n.isMobile ? n.osFamily : "Desktop", e(n)
    }), ym.modules.require(["system.browser"]), ym.modules.require(["system.logger"], function(e) {
      ym.logger = e
    }), ym.modules.define("system.logger", [], function(e, t) {
      function n(e, t) {
        var n = "";
        return ym.env.debug && (n += "(" + e + "): "), n += t
      }
      var r = "Yandex Maps JS API";
      e({
        assert: function(e, t) {
          e || ym.env.debug && window.console && console.log(n(r, t))
        },
        log: function(e) {
          ym.env.debug && window.console && console.log(n(r, e))
        },
        notice: function(e) {
          ym.env.debug && window.console && console.info(n(r, e))
        },
        warning: function(e) {
          ym.env.debug && window.console && console.warn(n(r, e))
        },
        error: function(e) {
          window.console && console.error(n(r, e))
        },
        exception: function(e, t) {
          throw new Error(n(e, t))
        }
      })
    }),
    function(e) {
      ym.modules.define("system.supports.csp", [], function(e) {
        var t = ym.env ? ym.env.browser : null;
        e({
          isSupported: "undefined" != typeof Blob && "undefined" != typeof URL,
          isNonceSupported: t && t.name && t.version ? !(t.name.search("Safari") != -1 && parseInt(t.version) < 10) : null
        })
      }), ym.modules.define("system.supports.css", [], function(e) {
        function t(e) {
          return "undefined" == typeof f[e] ? f[e] = n(e) : f[e]
        }

        function n(e) {
          return r(e) || r(p + i(e)) || r(d.cssPrefix + i(e))
        }

        function r(e) {
          return "undefined" != typeof o().style[e] ? e : null
        }

        function o() {
          return u || (u = document.createElement("div"))
        }

        function i(e) {
          return e ? e.substr(0, 1).toUpperCase() + e.substr(1) : e
        }

        function s(e) {
          var n = t(e);
          return n && n != e && (n = "-" + p + "-" + e), n
        }

        function a(e) {
          return c[e] && t("transitionProperty") ? s(c[e]) : null
        }
        var u, c = {
            transform: "transform",
            opacity: "opacity",
            transitionTimingFunction: "transition-timing-function",
            userSelect: "user-select",
            height: "height"
          },
          l = {},
          f = {},
          d = ym.env.browser,
          p = d.cssPrefix.toLowerCase();
        e({
          checkProperty: t,
          checkTransitionProperty: function(e) {
            return "undefined" == typeof l[e] ? l[e] = a(e) : l[e]
          },
          checkTransitionAvailability: a
        })
      }), ym.modules.define("system.supports.graphics", [], function(e) {
        function t() {
          if (!window.WebGLRenderingContext) return !1;
          var e = ym.env.browser,
            t = {
              "Samsung Internet": !0,
              AndroidBrowser: !0
            },
            n = "Webkit" == e.engine && +e.engineVersion < 537;
          return !n && !t[e.name]
        }

        function n() {
          if (!t()) return null;
          var e;
          try {
            var n = document.createElement("canvas"),
              r = n.getContext(e = "webgl", o);
            r || (r = n.getContext(e = "experimental-webgl", o), r || (e = null))
          } catch (i) {
            e = null
          }
          return e ? {
            contextName: e
          } : null
        }

        function r(e, t) {
          e.width = 226, e.height = 256, t.fillStyle = "#fff", t.fillRect(0, 0, 150, 150), t.globalCompositeOperation = "xor", t.fillStyle = "#f00", t.fillRect(10, 10, 100, 100), t.fillStyle = "#0f0", t.fillRect(50, 50, 100, 100);
          for (var n = t.getImageData(49, 49, 2, 2), r = [], o = 0; o < 16; o++) r.push(n.data[o]);
          return "0x0x0x0x0x0x0x0x0x0x0x0x0x255x0x255" == r.join("x")
        }
        var o = {
            failIfMajorPerformanceCaveat: !0,
            antialias: !1
          },
          i = {};
        e({
          hasSvg: function() {
            return "svg" in i || (i.svg = document.implementation && document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1")), i.svg
          },
          hasCanvas: function() {
            if (!("canvas" in i)) {
              var e = document.createElement("canvas"),
                t = "getContext" in e ? e.getContext("2d") : null;
              i.canvas = !!t && r(e, t)
            }
            return i.canvas
          },
          hasWebGl: function() {
            return "webgl" in i || (i.webgl = n()), i.webgl
          },
          hasVml: function() {
            if (!("vml" in i)) {
              var e, t = !1,
                n = document.createElement("div");
              n.innerHTML = '<v:shape id="yamaps_testVML"  adj="1" />', e = n.firstChild, e && e.style && (e.style.behavior = "url(#default#VML)", t = !e || "object" == typeof e.adj, n.removeChild(e)), i.vml = t
            }
            return i.vml
          },
          redetect: function() {
            i = {}
          },
          getWebGlContextName: function() {
            return i.webgl && i.webgl.contextName
          }
        })
      }), ym.modules.require(["system.supports.css", "system.supports.graphics", "system.supports.csp"], function(e, t, n) {
        ym.env.server.params.csp && !n.isSupported && console && console.warn("CSP is not suported in this browser"), ym.supports = {
          css: e,
          graphics: t,
          printPatchNeeded: !e.checkProperty("printColorAdjust"),
          csp: n
        }
      })
    }(this);
  setupAsync({
    "server": {
      "url": "//api-maps.yandex.ru/2.1.56",
      "path": "build/release",
      "params": {
        "csp": null
      },
      "version": "2.1"
    },
    "preload": {
      "load": "package.full"
    },
    "enterprise": false,
    "key": undefined,
    "apikey": undefined,
    "browser": {
      "name": "Chrome",
      "version": "63.0.3239.84",
      "base": "Chromium",
      "engine": "WebKit",
      "engineVersion": "537.36",
      "osName": "Windows 10",
      "osFamily": "Windows",
      "osVersion": "10.0",
      "isMobile": false,
      "cssPrefix": "Webkit"
    },
    "lang": "ru_RU",
    "languageCode": "ru",
    "countryCode": "RU",
    "hosts": {
      "api": {
        "main": "https://api-maps.yandex.ru/",
        "ua": "https://yandex.ru/legal/maps_termsofuse/?lang={{lang}}",
        "maps": "https://yandex.ru/maps/",
        "statCounter": "https://yandex.ru/clck/",
        "services": {
          "coverage": "https://api-maps.yandex.ru/services/coverage/",
          "geocode": "https://geocode-maps.yandex.ru/",
          "geoxml": "https://api-maps.yandex.ru/services/geoxml/",
          "inception": "https://api-maps.yandex.ru/services/inception/",
          "panoramaLocate": "https://api-maps.yandex.ru/services/panoramas/",
          "search": "https://api-maps.yandex.ru/services/search/",
          "suggest": "https://suggest-maps.yandex.ru/",
          "regions": "https://api-maps.yandex.ru/services/regions/",
          "route": "https://api-maps.yandex.ru/services/route/"
        }
      },
      "layers": {
        "map": "https://vec0%d.maps.yandex.net/tiles?l=map&%c&%l",
        "sat": "https://sat0%d.maps.yandex.net/tiles?l=sat&%c&%l",
        "skl": "https://vec0%d.maps.yandex.net/tiles?l=skl&%c&%l",
        "stv": "https://0%d.srdr.maps.yandex.net/?l=stv&%c&v=%v&%l&action=render",
        "sta": "https://lrs.maps.yandex.net/tiles?l=sta&%c&tm=%v&%l",
        "staHotspot": "https://lrs.maps.yandex.net/tiles?l=stj&%c&tm=%v&%l",
        "staHotspotKey": "%c&l=stj&tm=%v"
      },
      "traffic": "https://jgo.maps.yandex.net/",
      "trafficArchive": "https://jft.maps.yandex.net/"
    },
    "layers": {
      "map": {
        "version": "17.12.12-3",
        "scaled": true,
        "hotspotZoomRange": [13, 23]
      },
      "sat": {
        "version": "3.361.0"
      },
      "skl": {
        "version": "17.12.12-3",
        "scaled": true,
        "hotspotZoomRange": [13, 23]
      },
      "trf": {
        "version": "1513334085",
        "scaled": true
      },
      "sta": {
        "version": "0.28.1-0.1.3.1-0.2017.12.07.14.00.2.29.6-0.stable"
      },
      "stv": {
        "version": "3.84.0"
      }
    },
    "geolocation": {
      "longitude": 37.67528,
      "latitude": 47.955082,
      "isHighAccuracy": false,
      "span": {
        "longitude": 2.550605,
        "latitude": 2.548928
      }
    },
    "token": "f6fba7c44383277f88b3210c9b9cbfb6",
    "sign": (function(r) {
      function t(e) {
        if (n[e]) return n[e].exports;
        var o = n[e] = {
          exports: {},
          id: e,
          loaded: !1
        };
        return r[e].call(o.exports, o, o.exports, t), o.loaded = !0, o.exports
      }
      var n = {};
      return t.m = r, t.c = n, t.p = "", t(0)
    })([function(r, t, n) {
      "use strict";

      function e() {
        for (var r = ["9", "3", "2", "0", "b", "3", "a", "3", "b", "7", "8", "4", "6", "0", "2", "f", "4", "4", "9", "3", "7", "8", "8", "9", "c", "2", "b", "f", "b", "2", "3", "2", "c", "e", "4", "9", "3", "b", "4", "6"], t = [
            [(function() {
              var e = document.createElement("a");
              return e.href = "http://anioj.io/?=6y%23", e.search.length
            })() + 8, SVGPreserveAspectRatio.SVG_PRESERVEASPECTRATIO_XMINYMAX + 2],
            [DOMException.NOT_FOUND_ERR + 13, CSSRule.IMPORT_RULE + 6],
            [(function() {
              try {
                var e = document.createElement("a");
                e.appendChild(e)
              } catch (t) {
                return t.code
              }
            })() + 30, (function() {
              try {
                var e = document,
                  t = e.createRange(),
                  a = e.createRange(),
                  n = e.createElement("a");
                t.setStart(n, 0), t.setEnd(n, 0), t.compareBoundaryPoints(Range.START_TO_START, a)
              } catch (r) {
                return r.code
              }
            })() + 22]
          ], n = 0; n < t.length; n++) {
          var e = t[n][0],
            o = t[n][1],
            i = r[e];
          r[e] = r[o], r[o] = i
        }
        return r.join("")
      }
      var o, i = n(1),
        u = n(2);
      r.exports = function(r) {
        return o || (o = i(e())), i(u(r), o)
      }
    }, function(r, t) {
      "use strict";
      r.exports = function(r, t) {
        t = t || 0;
        for (var n = 0; n < r.length; n++) t += (t << 1) + (t << 4) + (t << 7) + (t << 8) + (t << 24), t ^= r.charCodeAt(n);
        return t >>> 0
      }
    }, function(r, t) {
      "use strict";
      r.exports = function(r) {
        r = r.replace(/^.*\/\//, "");
        var t = r.indexOf("?");
        if (-1 === t) return r;
        var n = t + 1,
          e = r.indexOf("#", n); - 1 === e && (e = r.length);
        var o = r.substring(n, e).split("&", 1e3);
        return r.substring(0, n) + o.sort().join("&") + r.substring(e)
      }
    }]),
    "distribution": {},
    "version": "2.1.56",
    "majorVersion": "2.1",
    "cssPrefix": "ymaps-2-1-56-",
    "coordinatesOrder": "latlong"
  })
})(this);
//end of yandex api
(function($) {
  "use strict";
  $(function() {

    //begin of yandex map shop-address.html
    var myMap;

    // Дождёмся загрузки API и готовности DOM.
    if ($('#map').length) {
      ymaps.ready(init);
    }


    function init() {

      // Создание экземпляра карты и его привязка к контейнеру с
      // заданным id ("map").
      myMap = new ymaps.Map('map', {
        // При инициализации карты обязательно нужно указать
        // её центр и коэффициент масштабирования.
        center: [55.744632, 37.566072], // Москва
        zoom: 16
      }, {
        searchControlProvider: 'yandex#search'
      });

      myMap.behaviors.disable('scrollZoom');
      setTimeout(function() {
        disableDragOnMobile();
      }, 200);

    }

    function disableDragOnMobile() {
      if ($(window).width() < 623) {
        myMap.behaviors.disable('drag');
      } else {
        myMap.behaviors.enable('drag');
      }
    }
    $(window).on('resize', function() {
      if ($('#map').length) {
        disableDragOnMobile();
      }

    });

    //end of yandex map shop-address.html
    //begin of .size visibility hidden/visible
    function checkHeaderAndHideSizeBlock() {
      if ($(window).scrollTop() > 0) {
        $('.size').addClass('js-invisible');
      } else {
        $('.size').removeClass('js-invisible');

      }
    }
    $(document).on('scroll', function() {
      checkHeaderAndHideSizeBlock();


    });
    $(window).on('load', function() {
      checkHeaderAndHideSizeBlock();


    });
    //end of .size visibility hidden/visible

    //begin of .sort click function
    $('.sort__main').click(function() {

      if ($(this).closest('.sort').hasClass('js-open')) {

        $('.sort.js-open').removeClass('js-open');

      } else {
        $('.sort.js-open').removeClass('js-open');
        $(this).closest('.sort').addClass('js-open');

      }

    });
    $('.js-apply').click(function() {
      $(this).closest('.sort').removeClass('js-open');
      $(this).closest('form').submit();
    });
    $('.js-select-all').click(function() {
      var $checkBoxes = $(this).closest('.sort').find('input');
      $checkBoxes.prop('checked', !$checkBoxes.prop('checked'));
    });

    /**
     * Поиск вариантов значений в фильтре
     */
    $('.js-filter-values-search').on('input', function() {
      var $this = $(this),
        $filterValues = $this.siblings('.js-filter-values'),
        val = $this.val().toLowerCase();

      $filterValues.each(function() {
        var $this = $(this),
          filterVal = $this.attr('data-value').toLowerCase();

        if (val == '' || filterVal.indexOf(val) == 0)
          $this.removeClass('hidden');
        else $this.addClass('hidden');
      });
    });

    $(document).mouseup(function(e) {
      var div = $(".sort.js-open");
      if (!div.is(e.target) && div.has(e.target).length === 0) {
        div.removeClass('js-open');
      }
    });
    //end of .sort click function
    //begin of fix .reveal_my close
    $('.reveal_my .close-button').click(function() {

      $('body,html').removeClass('is-reveal-open');
    });
    //end of fix .reveal_my close

    /**
     * Разные карусели
     */
    $(".sale").slick({
      infinite: true,
      dots: true,
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
    });
    $(".map").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesToShow: 5,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
      responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 3,
        }
      }, {
        breakpoint: 800,
        settings: {
          slidesToShow: 2,
        }
      }, {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }]
    });
    $(".girl").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesToShow: 7,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
      responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
        }
      }, {
        breakpoint: 800,
        settings: {
          slidesToShow: 2,
        }
      }, {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }]
    });
    //begin of .skirt__slider


    var imgUrl = [];
    $('.skirt__inner').each(function(index) {
      imgUrl.push($(this).find('img').prop('src'));

      $('.pants').append('<div><img src="' + imgUrl[index] + '" alt="" /></div>');

    });
    $('.pants').on('init', function(event, slick) {
      $('.pants .slick-dots li').each(function(index) {


        $(this).find('button').attr('style', 'background-image:url(' + imgUrl[index] + ');');

      });
      var heightDots = $('.pants .slick-dots').height();
      $('.pants .slick-next').css('top', heightDots + 100);
    });
    $(".pants").slick({
      infinite: true,
      dots: true,
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: true,
      swipeToSlide: false,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
      responsive: [{
        breakpoint: 1200,
        settings: {

        }
      }, {
        breakpoint: 800,
        settings: {

        }
      }, {
        breakpoint: 480,
        settings: {

        }
      }]
    });

    var slidesInnerHtml = $('.skirt__slider').html();
    var numSlides = $('.skirt__slide').length;
    if (numSlides != 1) {


      var numIllusionSlides = 10;
      var multiplyNum = numIllusionSlides / numSlides;
      if (multiplyNum > 1) {
        for (var i = 0; i < Math.ceil(multiplyNum); i++) {
          $(slidesInnerHtml).appendTo('.skirt__slider');
        }

      }
    }
    else {
        $(".skirt__slider").addClass('js-one');
        $('.skirt__next,.skirt__prev').hide();
    }

    $(".skirt__slider").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<i class="slick-prev "> </i>',
      nextArrow: '<i class="slick-next "> </i>',
      responsive: [{
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
        }
      }, {
        breakpoint: 800,
        settings: {
          slidesToShow: 2,
        }
      }, {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        }
      }]
    });
    $('.skirt__prev').click(function() {
      $('.skirt__slider').slick('slickPrev');
    });
    $('.skirt__next').click(function() {
      $('.skirt__slider').slick('slickNext');
    });

    $('.slirt__slider').slick('slickGoTo', numIllusionSlides / 2);
    //end of .skirt__slider
    $(".x-carousel-services").slick({
      infinite: true,
      dots: true,
      arrows: false,
      slidesPerRow: 1,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true
    });

    $(".x-carousel-news").slick({
      infinite: true,
      arrows: false,
      slidesPerRow: 1,
      slidesToShow: 1,
      slidesToScroll: 1,
      fade: true,
      swipeToSlide: true,
      autoplay: true,
      autoplaySpeed: 7000,
      autoplayHoverPause: true
    });

    //begin of jquery-zoom plugin
    // $(document).ready(function() {
    //   $('.skirt__inner').each(function() {
    //     var imgUrl = $(this).data('img');
    //     $(this).zoom({
    //       url: imgUrl
    //     });
    //   });
    //
    // });
    // $('.skirt__slider').on('afterChange',function(slick,currentSlide) {
    //   $('.skirt__inner').each(function() {
    //      $('.fancybox').fancybox();
    //   });
    // });
    //end of jquery-zoom plugin
    $('.x-carousel-news-link').on('click', function(e) {

      e.preventDefault();
      var $this = $(this),
        index = $this.closest('.x-carousel-news-links').find('.x-carousel-news-link').index($this);
      $('.x-carousel-news').slick('slickGoTo', index);
    });


    /**
     * Показ любого блока по наведению на другой
     */
    var $linkThis;
    var toggleLeaveTimer;
    $('[data-toggle-hover-dd]').on('mouseenter mouseleave', function(e) {
      $linkThis = $(this);
      var selector = '#' + $(this).data('toggle-hover-dd');
      if ($(selector).length > 0) {
        var $toggler = $(selector);
        var className = $toggler.data('toggler-hover-dd');
        if (e.type == 'mouseenter' && !$toggler.hasClass(className)) {
          $toggler.addClass(className);
          $linkThis.addClass('menu-base__link_active');

        }
        if (e.type == 'mouseleave' && $toggler.hasClass(className)) {
          toggleLeaveTimer = setTimeout(function() {
            $toggler.removeClass(className);
            $linkThis.removeClass('menu-base__link_active');

          }, 300);
        }
      }
    });
    $('[data-toggler-hover-dd]').on('mouseenter', function() {
      var link = $(this).prop('id');
      $linkThis = $('[data-toggle-hover-dd=' + link + ']');


      clearTimeout(toggleLeaveTimer);
    }).on('mouseleave', function() {

      var $toggler = $(this);

      $linkThis.removeClass('menu-base__link_active');
      var className = $toggler.data('toggler-hover-dd');
      if ($toggler.hasClass(className)) {
        toggleLeaveTimer = setTimeout(function() {
          $toggler.removeClass(className)
        }, 300);
      }
    });

  });
})(jQuery);
