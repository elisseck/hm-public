(function () {
  function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

  function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

  function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

  function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

  function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

  function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

  (window["webpackJsonp"] = window["webpackJsonp"] || []).push([["main"], {
    /***/
    0:
    /*!***************************!*\
      !*** multi ./src/main.ts ***!
      \***************************/

    /*! no static exports found */

    /***/
    function _(module, exports, __webpack_require__) {
      module.exports = __webpack_require__(
      /*! /Users/orin.fink/Work/thm/hm-public/web/themes/custom/hm-public-theme/bio-video-player/src/main.ts */
      "zUnb");
      /***/
    },

    /***/
    "4yKC":
    /*!************************************************!*\
      !*** ./src/app/scroll-transcript.directive.ts ***!
      \************************************************/

    /*! exports provided: ScrollTranscript */

    /***/
    function yKC(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "ScrollTranscript", function () {
        return ScrollTranscript;
      });
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/core */
      "fXoL"); // NOTE: this directive used to use scrollIntoView with window scrolling removed via CSS. However, it has been updated to pass
      // the top offset value of the element to the parent component. From there, the parent uses scrollTop with that value
      // on the transcript container. This way, we can scroll the element with overflow rather than the entire window, which is
      // better for responsive heights and layouts. We may want to discuss the value of keeping this functionality as a directive vs.
      // creating a transcript component. Right now, we still have to do the actual scrolling inside a function in the parent component.


      var ScrollTranscript = /*#__PURE__*/function () {
        function ScrollTranscript(_renderer, el) {
          _classCallCheck(this, ScrollTranscript);

          this._renderer = _renderer;
          this.topPosition = new _angular_core__WEBPACK_IMPORTED_MODULE_0__["EventEmitter"]();
          this.el = el.nativeElement;
        }

        _createClass(ScrollTranscript, [{
          key: "thdaScrollTranscript",
          set: function set(condition) {
            if (condition) {
              var topPos = this.el.offsetTop;
              this.updatePos(topPos);
            }
          }
        }, {
          key: "updatePos",
          value: function updatePos(topPos) {
            this.topPosition.emit(topPos);
          }
        }]);

        return ScrollTranscript;
      }();

      ScrollTranscript.ɵfac = function ScrollTranscript_Factory(t) {
        return new (t || ScrollTranscript)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["Renderer2"]), _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]));
      };

      ScrollTranscript.ɵdir = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineDirective"]({
        type: ScrollTranscript,
        selectors: [["", "thdaScrollTranscript", ""]],
        inputs: {
          thdaScrollTranscript: "thdaScrollTranscript"
        },
        outputs: {
          topPosition: "topPosition"
        }
      });
      /***/
    },

    /***/
    "AwPh":
    /*!**************************************!*\
      !*** ./src/app/transcript-timing.ts ***!
      \**************************************/

    /*! exports provided: TranscriptTiming */

    /***/
    function AwPh(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "TranscriptTiming", function () {
        return TranscriptTiming;
      });

      var TranscriptTiming = /*#__PURE__*/function () {
        function TranscriptTiming() {
          _classCallCheck(this, TranscriptTiming);

          this.offset = 0;
          this.time = 0;
        }

        _createClass(TranscriptTiming, [{
          key: "buildFromArray",
          value: function buildFromArray(timingPairArray) {
            var myTime = Number(timingPairArray[0]);
            var myOffset = Number(timingPairArray[1]);
            if (!isNaN(myTime)) this.time = myTime;
            if (!isNaN(myOffset)) this.offset = myOffset;
            return this;
          }
        }]);

        return TranscriptTiming;
      }();
      /***/

    },

    /***/
    "AytR":
    /*!*****************************************!*\
      !*** ./src/environments/environment.ts ***!
      \*****************************************/

    /*! exports provided: environment */

    /***/
    function AytR(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "environment", function () {
        return environment;
      }); // The file contents for the current environment will overwrite these during build.
      // The build system defaults to the dev environment which uses `environment.ts`, but if you do
      // `ng build --env=prod` then `environment.prod.ts` will be used instead.
      // The list of which env maps to which file can be found in `.angular-cli.json`.


      var environment = {
        production: false
      };
      /***/
    },

    /***/
    "Sy1n":
    /*!**********************************!*\
      !*** ./src/app/app.component.ts ***!
      \**********************************/

    /*! exports provided: AppComponent */

    /***/
    function Sy1n(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "AppComponent", function () {
        return AppComponent;
      });
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _transcript_timing__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! ./transcript-timing */
      "AwPh");
      /* harmony import */


      var _videogular_ngx_videogular_core__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @videogular/ngx-videogular/core */
      "4w57");
      /* harmony import */


      var _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! @videogular/ngx-videogular/controls */
      "v2j/");
      /* harmony import */


      var _angular_common__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! @angular/common */
      "ofXK");
      /* harmony import */


      var _scroll_transcript_directive__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! ./scroll-transcript.directive */
      "4yKC");

      var _c0 = ["myVideoArea"];
      var _c1 = ["myVideoPlayer"];
      var _c2 = ["transcript"];

      function AppComponent_div_30_p_5_Template(rf, ctx) {
        if (rf & 1) {
          var _r8 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵgetCurrentView"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](0, "p", 28);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](1, "span", 29);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("topPosition", function AppComponent_div_30_p_5_Template_span_topPosition_1_listener($event) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵrestoreView"](_r8);

            var ctx_r7 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵnextContext"](2);

            return ctx_r7.advanceTranscript($event);
          });

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
        }

        if (rf & 2) {
          var onePiece_r5 = ctx.$implicit;
          var i_r6 = ctx.index;

          var ctx_r4 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵnextContext"](2);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](1);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵclassProp"]("selected", ctx_r4.isTranscriptPieceActive(i_r6));

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("thdaScrollTranscript", ctx_r4.isTranscriptPieceActive(i_r6))("innerHTML", onePiece_r5, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵsanitizeHtml"]);
        }
      }

      function AppComponent_div_30_Template(rf, ctx) {
        if (rf & 1) {
          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](0, "div", 23);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](1, "div", 23);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](2, "div", 24, 25);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](4, "div", 26);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtemplate"](5, AppComponent_div_30_p_5_Template, 2, 4, "p", 27);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
        }

        if (rf & 2) {
          var ctx_r2 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵnextContext"]();

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](2);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵstyleProp"]("height", ctx_r2.transcriptAreaHeight, "px");

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵclassProp"]("transcript--mobile-active", !ctx_r2.mobileDetails);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](3);

          _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("ngForOf", ctx_r2.transcriptPieces);
        }
      }

      var AppComponent = /*#__PURE__*/function () {
        function AppComponent(elementRef) {
          _classCallCheck(this, AppComponent);

          this.elementRef = elementRef;
          this.mobileDetails = false;
          this.transcriptAreaHeight = 100;
          this.myMatchContext = [];
          this.wideScreen = false;
          this.storyHasMatches = true;
          this.videoPositionInSeconds = 0;
          this.transcriptHeightInitialized = false;
          this.currentIndex = 0;
          this.source = this.elementRef.nativeElement.getAttribute('source');
          this.source2 = this.elementRef.nativeElement.getAttribute('source2');
          this.title = this.elementRef.nativeElement.getAttribute('title');
          this.title2 = this.elementRef.nativeElement.getAttribute('title2');
          this.thumb = this.source.replace('video', 'image');
          this.thumb2 = this.source2.replace('video', 'image');
          this.timingPairs = this.elementRef.nativeElement.getAttribute('timingPairs');
          var timingPairs1 = this.timingPairs.split(/[\$]/)[0];
          var timingParis2 = this.timingPairs.split(/[\$]/)[1];
          this.transcriptText = this.elementRef.nativeElement.getAttribute('transcriptText');
          this.transcriptText = this.transcriptText.replace(/(\$)\1+/gi, "\n\n").replace(/[\\]/, '');
          ;
          this.transcriptText1 = this.transcriptText.split(/[\$]/)[0];
          this.transcriptText2 = this.transcriptText.split(/[\$]/)[1];
          this.timingPairsVideo1 = this.timingPairsToJSON(timingPairs1);
          this.timingPairsVideo2 = this.timingPairsToJSON(timingParis2);
          this.playlist = [{
            title: this.title,
            src: this.source,
            type: 'video/mp4',
            thumb: this.thumb
          }, {
            title: this.title2,
            src: this.source2,
            type: 'video/mp4',
            thumb: this.thumb2
          }];
          this.currentItem = this.playlist[this.currentIndex];
          this.previousItem = this.playlist[this.currentIndex + 1];
        }

        _createClass(AppComponent, [{
          key: "timingPairsToJSON",
          value: function timingPairsToJSON(timingPairs) {
            var timingPairsArray = timingPairs.split(':').map(function (e) {
              return e.split(',');
            });
            var newTimingPairs = [];

            var _iterator = _createForOfIteratorHelper(timingPairsArray),
                _step;

            try {
              for (_iterator.s(); !(_step = _iterator.n()).done;) {
                var timingPairArray = _step.value;
                var pair = new _transcript_timing__WEBPACK_IMPORTED_MODULE_1__["TranscriptTiming"]().buildFromArray(timingPairArray);
                newTimingPairs.push(pair);
              }
            } catch (err) {
              _iterator.e(err);
            } finally {
              _iterator.f();
            }

            return newTimingPairs;
          }
        }, {
          key: "ngOnInit",
          value: function ngOnInit() {
            this.myStory = {
              transcript: this.transcriptText1,
              timingPairs: this.timingPairsVideo1
            };
            this.transcriptPieces = [];
            this.transcriptPieces.push("");
            this.currentActiveTranscriptPiece = -1;
            this.ComputeTimesForOffsets();
            this.ComputeTimedTranscriptWithMatches();
          } // Helper function to bold match text in the transcript, and break transcript up into pieces to
          // highlight a piece based on video transcript timing.  If there are no matches, then no text will get bolded.

        }, {
          key: "ComputeTimedTranscriptWithMatches",
          value: function ComputeTimedTranscriptWithMatches() {
            var matchOffset;
            var matchEndOffset;
            var textWithBoldedMatches;
            var outOfBoundsOffset;
            var timingIndexToCheckFirst;

            if (this.myStory.transcript == null || this.myStory.transcript.length == 0) {
              this.transcriptPieces = [];
              this.transcriptPieces.push("");
              return; // give up if there is no transcript
            } // NOTE: assumes this.myStory.timing.length >= 1
            // Pass 1: for every match BLAH, add in <b> and </b> markers around BLAH in transcript text.
            // As such inserts are done, update the offset numbers in this.myStory.timingPairs.  The plain transcript
            // will transform into textWithBoldedMatches.
            // Pass 2: use this.myStory.timing to break textWithBoldedMatches (i.e., the transcript with matches)
            // into this.transcriptPieces.
            // Pass 1: walk the matches from last one (greatest offset into transcript) to first...
            // Once a match is processed, never consider those characters again, i.e., even if match offsets
            // and scoring words somehow overlap/intermingle, the logic here will never allow for a case like
            // <b>ok here <b>bad, bold in bold</b></b> because the ending </b> of match N will never be placed
            // after the start <b> of match N+1.


            outOfBoundsOffset = this.myStory.transcript.length; // index transcriptText.length out of bounds (index transcriptText.length-1 still valid for length >= 1)

            textWithBoldedMatches = "";
            timingIndexToCheckFirst = this.myStory.timingPairs.length - 1; // working from end of transcript back to front, so start with last timing entry

            for (var iMatch = this.myMatchContext.length - 1; iMatch >= 0; iMatch--) {
              matchOffset = this.myMatchContext[iMatch].startOffset;
              matchEndOffset = this.myMatchContext[iMatch].endOffset;

              if (matchOffset < outOfBoundsOffset) {
                // there is room in text to highlight this match
                // NOTE: matchEndOffset might be one past the end of transcriptText, which is
                // ok for using it with transcriptText.substring(matchOffset, endingOffset):
                // TODO: The following sort of string appending construction may be time-consuming - re-implement later once the means
                // of transcript contruction with timing has been formalized (e.g., it may be replaced or augmented with closed-captioning).
                // We now have processed transcript from original offset matchOffset to its end.
                // We insert 3 characters at matchOffset and 4 more at matchEndOffset.
                if (matchEndOffset < outOfBoundsOffset) {
                  textWithBoldedMatches = "<b>" + this.myStory.transcript.substring(matchOffset, matchEndOffset) + "</b>" + this.myStory.transcript.substring(matchEndOffset, outOfBoundsOffset) + textWithBoldedMatches;
                } else {
                  // the match extends to the end of this chunk being considered.
                  textWithBoldedMatches = "<b>" + this.myStory.transcript.substring(matchOffset, matchEndOffset) + "</b>" + textWithBoldedMatches;
                }

                outOfBoundsOffset = matchOffset; // from match forward, no longer process (to avoid any overlapping issues)

                while (this.myStory.timingPairs[timingIndexToCheckFirst].offset >= matchOffset && timingIndexToCheckFirst > 0) {
                  timingIndexToCheckFirst--; // determine max number of timing entries to be checked for update based on <b>,</b> inserts
                }

                for (var iTiming = timingIndexToCheckFirst; iTiming < this.myStory.timingPairs.length; iTiming++) {
                  if (this.myStory.timingPairs[iTiming].offset > matchOffset) {
                    // Grow offset by 3 for <b> and perhaps an additional 4 for </b>
                    if (this.myStory.timingPairs[iTiming].offset >= matchEndOffset) this.myStory.timingPairs[iTiming].offset += 7;else this.myStory.timingPairs[iTiming].offset += 3;
                  } // else no offset adjustment needed for time entries at or before the matchOffset insert; e.g.,
                  // if match at "snow" and now we have <b>snow</b> keep timing offset pointed to start of <b>

                }
              }
            }

            if (this.myMatchContext.length > 0) {
              // Transcript from outOfBoundsOffset to end already processed.  Tack on any text
              // that precedes the first match.
              if (outOfBoundsOffset > 0) textWithBoldedMatches = this.myStory.transcript.substring(0, outOfBoundsOffset) + textWithBoldedMatches;
            } else {
              // With no matches, this.myStory.timingPairs[] is unchanged and textWithBoldedMatches == transcriptText
              textWithBoldedMatches = this.myStory.transcript;
            } // NOTE: at this point there has been no replacement of <br> for \n in textWithBoldedMatches, to simplify all the offset adjustments.
            // Do the replacement as chunks of transcript are moved intothis.transcriptPieces.


            this.transcriptPieces = [];
            var transcriptPiece;
            var re = /\n/g; // Pass 2: use the adjusted this.myStory.timingPairs (to account for <b></b> inserts) to break
            // textWithBoldedMatches(i.e., the transcript with matches) into this.transcriptPieces.

            if (this.myStory.timingPairs.length > 1) {
              // Fill transcript by breaking it into N pieces, corresponding to the N timing pieces.
              for (var i = 0; i < this.myStory.timingPairs.length - 1; i++) {
                if (this.myStory.timingPairs[i + 1].offset > this.myStory.timingPairs[i].offset) {
                  // Something worthwhile for this piece.
                  transcriptPiece = textWithBoldedMatches.substring(this.myStory.timingPairs[i].offset, this.myStory.timingPairs[i + 1].offset);
                  transcriptPiece = transcriptPiece.replace(re, '<br>');
                  this.transcriptPieces.push(transcriptPiece);
                } else // Empty string for this timing entry (ideally bogus timing entry would not even be there ever)
                  this.transcriptPieces.push("");
              }
            } else {
              // No timing (or just one entry), so have all of transcript text be in one piece,
              // and do not make it active (keep active indicator == -1).
              transcriptPiece = textWithBoldedMatches.replace(re, '<br>');
              this.transcriptPieces.push(transcriptPiece);
            }
          } // Something off about the offset. Will look into when I return

        }, {
          key: "advanceTranscript",
          value: function advanceTranscript(offset) {
            if (offset > 18) this.transcript.nativeElement.scrollTop = offset - 22;
          }
        }, {
          key: "isTranscriptPieceActive",
          value: function isTranscriptPieceActive(whichPiece) {
            return whichPiece == this.currentActiveTranscriptPiece;
          }
        }, {
          key: "onPlayerReady",
          value: function onPlayerReady(api) {
            this.api = api;
            this.api.getDefaultMedia().subscriptions.ended.subscribe(this.nextVideo.bind(this));
          }
        }, {
          key: "nextVideo",
          value: function nextVideo() {
            this.previousItem = this.currentItem;
            this.currentIndex++;

            if (this.currentIndex === this.playlist.length) {
              this.currentIndex = 0;
              this.myStory = {
                transcript: this.transcriptText1,
                timingPairs: this.timingPairsVideo1
              };
              this.transcriptPieces = [];
              this.transcriptPieces.push("");
              this.currentActiveTranscriptPiece = -1;
              this.ComputeTimesForOffsets();
              this.ComputeTimedTranscriptWithMatches();
            } else {
              this.myStory = {
                transcript: this.transcriptText2,
                timingPairs: this.timingPairsVideo2
              };
              this.transcriptPieces = [];
              this.transcriptPieces.push("");
              this.currentActiveTranscriptPiece = -1;
              this.ComputeTimesForOffsets();
              this.ComputeTimedTranscriptWithMatches();
            }

            this.currentItem = this.playlist[this.currentIndex];
          }
        }, {
          key: "onClickPlaylistItem",
          value: function onClickPlaylistItem(item, index) {
            this.currentIndex = index;
            this.currentItem = item;
          }
        }, {
          key: "isLoaded",
          value: function isLoaded() {
            this.initTranscriptHeight();
          }
        }, {
          key: "initTranscriptHeight",
          value: function initTranscriptHeight() {
            this.computeTranscriptAreaHeight(window.innerWidth, window.innerHeight);
          }
        }, {
          key: "computeTranscriptAreaHeight",
          value: function computeTranscriptAreaHeight(fullWindowWidth, fullWindowHeight) {
            // Block out height for other elements aside from transcript area.
            // If those heights not computable yet, use a default.
            // This work influenced by: http://stackoverflow.com/questions/35527559/angular2-get-window-width-onresize
            // !!!TBD!!! TODO: Remove numeric constants here that assume certain positioning and sizing and styling.
            // !!!TBD!!! TODO: Remove the need to bring in ElementRef just so that I could get height of videoPlayerAndControlsAreaRef
            // This is frowned upon but I wanted to get a release out "quickly" for beta testing.
            var blockOutHeight = 344;
            var extrasHeight = 54; // !!!TBD!!! very ugly dependency here, of "knowing" that navbar needs at least 54 pixels, but it gets worse...
            // Also, account for increasing font sizes at larger widths for the navbar, plus we are adding in a header image with height 108 when content width >= 768px

            if (fullWindowWidth >= 600) {
              if (fullWindowWidth >= 960) {
                extrasHeight += 120; // !!!TBD!!! more ugliness, knowing that styles.css saves 174px (120+54) for widths >= 960

                blockOutHeight += 20;
              } else if (fullWindowWidth >= 768) {
                extrasHeight += 116; // !!!TBD!!! more ugliness, knowing that styles.css saves 170px (116+54) for widths >= 768 but < 960

                blockOutHeight += 20;
              } else {
                extrasHeight += 4; // !!!TBD!!! more ugliness, knowing that styles.css saves 58px (4+54) for widths >= 600 but < 768

                blockOutHeight += 20;
              }
            }

            if (this.videoPlayerAndControlsAreaRef) {
              blockOutHeight = this.videoPlayerAndControlsAreaRef.nativeElement.offsetHeight + 10; // TODO: update when possible to remove need to access nativeElement
            }

            var newTranscriptHeight = fullWindowHeight - blockOutHeight - extrasHeight;
            if (newTranscriptHeight < 100) newTranscriptHeight = 100;

            if (this.videoPlayerRef) {
              var aspectRatio = this.videoPlayerRef.api.videogularElement.offsetWidth / this.videoPlayerRef.api.videogularElement.offsetHeight;

              if (fullWindowWidth >= 550 && this.wideScreen === false) {
                this.transcriptAreaHeight = 220;
              } // Widescreen capability is currently commented out until a design is done
              // else if (fullWindowWidth >= 768 && this.wideScreen === true) {
              //     if (this.storyHasMatches === true) this.transcriptAreaHeight = fullWindowHeight - (this.videoPlayerRef.api.videogularElement.offsetHeight + 120);
              //     else this.transcriptAreaHeight = fullWindowHeight - (this.videoPlayerRef.api.videogularElement.offsetHeight + 70);
              // }
              else {
                  if (this.storyHasMatches === true) this.transcriptAreaHeight = fullWindowHeight - (this.videoPlayerRef.api.videogularElement.offsetHeight + 250);else this.transcriptAreaHeight = fullWindowHeight - (this.videoPlayerRef.api.videogularElement.offsetHeight + 215);
                }
            }
          }
        }, {
          key: "onResize",
          value: function onResize(event) {
            this.computeTranscriptAreaHeight(window.innerWidth, window.innerHeight);
          }
        }, {
          key: "adjustVideoCurrentTime",
          value: function adjustVideoCurrentTime() {
            var movieTimeInSecs;
            movieTimeInSecs = this.api.getDefaultMedia().currentTime; // One-time setup of video transcript height based on video player (and player controls) height:

            if (!this.transcriptHeightInitialized) {
              this.computeTranscriptAreaHeight(window.innerWidth, window.innerHeight);
              this.transcriptHeightInitialized = true;
            }

            this.videoPositionInSeconds = movieTimeInSecs; // Possibly adjust which transcript piece is highlighted as well.

            var maxTimingEntries = 0;
            if (this.myStory && this.myStory.timingPairs) maxTimingEntries = this.myStory.timingPairs.length;

            if (maxTimingEntries > 1) {
              // Only bother with selecting a piece of the transcript if there are 2+ pieces.
              // The means of activating a piece is via this.currentActiveTranscriptPiece.
              // NOTE: max value for this.currentActiveTranscriptPiece == maxTimingEntries - 2 under assumption
              // that final timing entry in this.myStory.timingPairs equals transcript length as offset, video duration as timing, i.e.,
              // that last entry does not help set an active region by itself but sets maximums on offset and video timing.
              // This assumption allows us to safely make use of this.currentActiveTranscriptPiece + 1 as an index into this.myStory.timingPairs.
              var movieTimeInMSecs = movieTimeInSecs * 1000;

              if (this.currentActiveTranscriptPiece < 0 || movieTimeInMSecs < this.myStory.timingPairs[this.currentActiveTranscriptPiece].time || movieTimeInMSecs > this.myStory.timingPairs[this.currentActiveTranscriptPiece + 1].time) {
                // There will be a change to this.currentActiveTranscriptPiece based on movieTimeInMSecs
                if (movieTimeInMSecs < this.myStory.timingPairs[1].time) this.currentActiveTranscriptPiece = 0;else if (movieTimeInMSecs >= this.myStory.timingPairs[maxTimingEntries - 2].time) this.currentActiveTranscriptPiece = maxTimingEntries - 2;else {
                  for (var i = 1; i < maxTimingEntries - 1; i++) {
                    if (movieTimeInMSecs < this.myStory.timingPairs[i + 1].time) {
                      this.currentActiveTranscriptPiece = i;
                      break;
                    }
                  }
                }
              }
            }
          }
        }, {
          key: "ComputeTimesForOffsets",
          value: function ComputeTimesForOffsets() {
            // Use this.myStory.timingPairs and this.myStory.matchTerms to compute this.myMatchContext for each match in matchTerms
            var i = 0;
            var matchIndex = 0;
            var maxTimingPairIndex;
            var givenMatchesCount;
            var newEntry;
            if (this.myStory.timingPairs == null) maxTimingPairIndex = -1;else maxTimingPairIndex = this.myStory.timingPairs.length - 1;

            if (givenMatchesCount == 0 || maxTimingPairIndex <= 0) {
              this.storyHasMatches = false;
              this.myMatchContext = [];
              return;
            }

            this.storyHasMatches = true; // As we move through this.myStory.timingPairs in ascending offset order, we don't go back,
            // i.e., i starts at 0 but moves forward within this outer while loop rather than being
            // reset to 0 each time:

            while (matchIndex < givenMatchesCount) {
              if (i == 0) newEntry.time = this.myStory.timingPairs[0].time;else newEntry.time = this.myStory.timingPairs[i - 1].time;
              this.myMatchContext.push(newEntry);
              matchIndex++; // Note: service puts matches in order, so this.myStory.timingPairs[N+1].startOffset >= this.myStory.timingPairs[N].startOffset
            }
          }
        }]);

        return AppComponent;
      }();

      AppComponent.ɵfac = function AppComponent_Factory(t) {
        return new (t || AppComponent)(_angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdirectiveInject"](_angular_core__WEBPACK_IMPORTED_MODULE_0__["ElementRef"]));
      };

      AppComponent.ɵcmp = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵdefineComponent"]({
        type: AppComponent,
        selectors: [["app-root"]],
        viewQuery: function AppComponent_Query(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵviewQuery"](_c0, 1);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵviewQuery"](_c1, 1);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵviewQuery"](_c2, 1);
          }

          if (rf & 2) {
            var _t;

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵqueryRefresh"](_t = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵloadQuery"]()) && (ctx.videoPlayerAndControlsAreaRef = _t.first);
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵqueryRefresh"](_t = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵloadQuery"]()) && (ctx.videoPlayerRef = _t.first);
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵqueryRefresh"](_t = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵloadQuery"]()) && (ctx.transcript = _t.first);
          }
        },
        decls: 31,
        vars: 10,
        consts: [[3, "resize"], [1, "row", "video-container"], [1, "col-sm-8"], [1, "video__title"], [3, "onPlayerReady"], ["myVideoPlayer", ""], [1, "vg-controls"], [1, "vg-controls__inner-wrapper"], [1, "vg-play-pause"], [1, "vg-time-display", 3, "vgProperty"], [1, "vg-scrub-bar"], [1, "vg-scrub-bar-current-time", 3, "vgSlider"], ["width", "21", "height", "15", "viewBox", "0 0 21 15", "xmlns", "http://www.w3.org/2000/svg", 1, "vg-volume-speaker"], ["d", "M5.428 3.872l5.428-3.62V14.73l-5.428-3.62H0V3.872h5.428zm7.275-1.03l1.248-.96c1.34 1.628 2.01 3.498 2.01 5.61 0 2.05-.64 3.877-1.92 5.48l-1.21-.994c1.037-1.327 1.555-2.822 1.555-4.487 0-1.748-.56-3.298-1.682-4.65 0 0 1.12 1.352 0 0zM17.623 15l.11-.145c1.713-2.147 2.57-4.59 2.57-7.328 0-2.774-.87-5.235-2.607-7.382L17.588 0l-1.502 1.158.126.145c1.484 1.82 2.226 3.896 2.226 6.224 0 2.28-.718 4.325-2.153 6.134l-.127.146L17.624 15z", "fill", "#333", "fill-rule", "evenodd"], [1, "vg-volume"], ["aria-label", "video", "preload", "auto", "playsinline", "", 1, "", 3, "src", "vgMedia", "poster", "loadeddata", "timeupdate", "ended"], ["media", ""], [1, "col-sm-4", "next-vid"], [1, "row", "next-vid__preview", 3, "click"], [1, "col-md-6"], ["alt", "", 1, "next-vid__thumb", 3, "src"], [1, "col-md-6", "next-vid__title"], ["class", "", 4, "ngIf"], [1, ""], [1, "transcript", "adjust-height"], ["transcript", ""], [1, "containerForTranscriptTextArea"], ["class", "transcriptTextArea", 4, "ngFor", "ngForOf"], [1, "transcriptTextArea"], [3, "thdaScrollTranscript", "innerHTML", "topPosition"]],
        template: function AppComponent_Template(rf, ctx) {
          if (rf & 1) {
            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](0, "div", 0);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("resize", function AppComponent_Template_div_resize_0_listener($event) {
              return ctx.onResize($event);
            }, false, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵresolveWindow"]);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](1, "div", 1);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](2, "section", 2);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](3, "h3", 3);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](4);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](5, "vg-player", 4, 5);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("onPlayerReady", function AppComponent_Template_vg_player_onPlayerReady_5_listener($event) {
              return ctx.onPlayerReady($event);
            });

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](7, "vg-controls", 6);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](8, "div", 7);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](9, "vg-play-pause", 8);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](10, "vg-time-display", 9);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](11, " / ");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](12, "vg-time-display", 9);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](13, "vg-scrub-bar", 10);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](14, "vg-scrub-bar-current-time", 11);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵnamespaceSVG"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](15, "svg", 12);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](16, "title");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](17, " Speaker volume icon ");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](18, "path", 13);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵnamespaceHTML"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](19, "vg-volume", 14);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](20, "video", 15, 16);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("loadeddata", function AppComponent_Template_video_loadeddata_20_listener() {
              return ctx.isLoaded();
            })("timeupdate", function AppComponent_Template_video_timeupdate_20_listener() {
              return ctx.adjustVideoCurrentTime();
            })("ended", function AppComponent_Template_video_ended_20_listener() {
              return ctx.nextVideo();
            });

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](22, "section", 17);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](23, "h3");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](24, "Up Next");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](25, "div", 18);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵlistener"]("click", function AppComponent_Template_div_click_25_listener() {
              return ctx.nextVideo();
            });

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](26, "div", 19);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelement"](27, "img", 20);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementStart"](28, "div", 21);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtext"](29);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtemplate"](30, AppComponent_div_30_Template, 6, 5, "div", 22);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵelementEnd"]();
          }

          if (rf & 2) {
            var _r1 = _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵreference"](21);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](4);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtextInterpolate"](ctx.currentItem.title);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](6);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("vgProperty", "current");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](2);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("vgProperty", "total");

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](2);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("vgSlider", true);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](6);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("src", ctx.currentItem.src, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵsanitizeUrl"])("vgMedia", _r1)("poster", ctx.currentItem.thumb, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵsanitizeUrl"]);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](7);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("src", ctx.previousItem.thumb, _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵsanitizeUrl"]);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](2);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵtextInterpolate"](ctx.previousItem.title);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵadvance"](1);

            _angular_core__WEBPACK_IMPORTED_MODULE_0__["ɵɵproperty"]("ngIf", ctx.timingPairs);
          }
        },
        directives: [_videogular_ngx_videogular_core__WEBPACK_IMPORTED_MODULE_2__["VgPlayerComponent"], _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_3__["VgControlsComponent"], _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_3__["VgPlayPauseComponent"], _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_3__["VgTimeDisplayComponent"], _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_3__["VgScrubBarComponent"], _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_3__["VgScrubBarCurrentTimeComponent"], _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_3__["VgVolumeComponent"], _videogular_ngx_videogular_core__WEBPACK_IMPORTED_MODULE_2__["VgMediaDirective"], _angular_common__WEBPACK_IMPORTED_MODULE_4__["NgIf"], _angular_common__WEBPACK_IMPORTED_MODULE_4__["NgForOf"], _scroll_transcript_directive__WEBPACK_IMPORTED_MODULE_5__["ScrollTranscript"]],
        styles: [".match__prev-button[_ngcontent-%COMP%], .match__next-button[_ngcontent-%COMP%], .story-nav__prev-button[_ngcontent-%COMP%], .story-nav__next-button[_ngcontent-%COMP%] {\n  font-family: 'Source Sans Pro', sans-serif;\n}\n\n.about__link[_ngcontent-%COMP%], .about__link[_ngcontent-%COMP%]:visited, .playlist-button[_ngcontent-%COMP%] {\n  font-family: 'Source Sans Pro', sans-serif;\n  font-weight: 600;\n}\n\n.playlist__total[_ngcontent-%COMP%] {\n  font-family: 'Source Sans Pro', sans-serif;\n  font-style: italic;\n  font-weight: 600;\n}\n\n.tabs__tab[_ngcontent-%COMP%] {\n  font-family: 'Source Sans Pro', sans-serif;\n  font-weight: 700;\n}\n\n.header-1[_ngcontent-%COMP%], .header-2[_ngcontent-%COMP%], .header-3[_ngcontent-%COMP%], .header-4[_ngcontent-%COMP%], .video-header[_ngcontent-%COMP%], .about__heading[_ngcontent-%COMP%], .page-title[_ngcontent-%COMP%], .back-button[_ngcontent-%COMP%], .playlist__title[_ngcontent-%COMP%], .next-vid__da-button[_ngcontent-%COMP%] {\n  font-family: 'Oswald', sans-serif;\n  font-weight: 500;\n}\n\n.header-1[_ngcontent-%COMP%] {\n  color: #232323;\n  font-size: 1.85714rem;\n  line-height: 1.22222em;\n  margin: 0 0 2.23077em;\n  text-transform: uppercase;\n}\n\n.header-2[_ngcontent-%COMP%] {\n  color: #232323;\n  font-size: 1.57143em;\n  line-height: 26px;\n  margin: 0 0 0.71429em;\n  padding: 0;\n}\n\n.header-3[_ngcontent-%COMP%] {\n  color: #232323;\n  font-size: 1.57142857em;\n  margin-bottom: 0;\n  margin-top: 0;\n  padding-bottom: 1.11111em;\n  padding-top: 0;\n}\n\n.header-4[_ngcontent-%COMP%] {\n  color: #232323;\n  font-size: 1.57142857em;\n  margin: 0 0 0.3em;\n  padding: 0;\n}\n\n.bold[_ngcontent-%COMP%] {\n  font-weight: 700;\n}\n\n.italic[_ngcontent-%COMP%] {\n  font-style: italic;\n}\n\n.list-without-styles[_ngcontent-%COMP%] {\n  list-style-type: none;\n  padding: 0;\n}\n\n@media screen and (min-width: 769px) {\n  .video-header[_ngcontent-%COMP%], .about--mobile[_ngcontent-%COMP%], .back-button--mobile[_ngcontent-%COMP%], .playlist-button--mobile[_ngcontent-%COMP%], .tabs[_ngcontent-%COMP%], .mobile-only[_ngcontent-%COMP%] {\n    display: none !important;\n  }\n}\n\n@media screen and (max-width: 544px) {\n  \n  .tablet-and-above[_ngcontent-%COMP%] {\n    display: none !important;\n  }\n}\n\n@media screen and (max-width: 768px) {\n  .about--desktop[_ngcontent-%COMP%], .page-title[_ngcontent-%COMP%], .back-button--desktop[_ngcontent-%COMP%], .playlist-button[_ngcontent-%COMP%], .playlist-button--desktop[_ngcontent-%COMP%], .playlist[_ngcontent-%COMP%], .desktop-only[_ngcontent-%COMP%] {\n    display: none !important;\n  }\n}\n\n.container-fluid[_ngcontent-%COMP%] {\n  font-size: 1rem;\n  padding-top: 1.14285714em;\n  padding-bottom: 1.14285714em;\n  max-width: 107.14285714em;\n}\n\n.container-fluid[_ngcontent-%COMP%]:focus {\n  outline: 0;\n}\n\n@media screen and (min-width: 544px) {\n  .container-fluid[_ngcontent-%COMP%] {\n    padding-top: 2.14285714em;\n  }\n}\n\n@media screen and (min-width: 768px) {\n  .container-fluid[_ngcontent-%COMP%] {\n    padding-left: 2.14285714em;\n    padding-right: 2.14285714em;\n    padding-bottom: 2.14285714em;\n  }\n}\n\nvideo[_ngcontent-%COMP%] {\n  max-width: 500px;\n  margin: 0 auto;\n}\n\nvg-player[_ngcontent-c0][_ngcontent-%COMP%] {\n  height: auto;\n  padding-bottom: 34px;\n}\n\n.vg-controls[_ngcontent-%COMP%] {\n  align-items: center;\n  background-color: #cccccc;\n  height: 2.14285714em;\n}\n\n.vg-controls__inner-wrapper[_ngcontent-%COMP%] {\n  align-items: center;\n  display: flex;\n  flex: 2;\n  margin: 0 auto;\n  max-width: 35.71428571em;\n}\n\n@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {\n  .vg-controls__inner-wrapper[_ngcontent-%COMP%] {\n    max-width: 100%;\n  }\n}\n\n.vg-play-pause[_ngcontent-%COMP%] {\n  width: 2.14285714em;\n}\n\n.vg-scrub-bar-current-time[_ngcontent-%COMP%] {\n  align-items: center;\n  background-color: #232323;\n  height: 0.14285714em;\n  position: relative;\n  top: initial;\n}\n\n.vg-scrub-bar-current-time[_ngcontent-%COMP%]   .background[_ngcontent-%COMP%] {\n  border: 1px solid #2E2B71;\n}\n\n.vg-scrub-bar-current-time[_ngcontent-%COMP%]   .slider[_ngcontent-%COMP%] {\n  background-color: #2E2B71;\n  box-shadow: none;\n  height: 0.85714286em;\n  margin-top: 0;\n  width: 0.85714286em;\n}\n\n.vg-play-pause[_ngcontent-%COMP%], .vg-time-display[_ngcontent-%COMP%], .vg-scrub-bar[_ngcontent-%COMP%], .vg-volume[_ngcontent-%COMP%] {\n  align-items: center;\n  color: #232323;\n  height: 2.14285714em;\n}\n\n.vg-time-display[_ngcontent-%COMP%] {\n  flex: 0;\n  margin: 0 0.35714286em;\n}\n\n@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {\n  .vg-time-display[_ngcontent-%COMP%] {\n    flex: 0 1 auto;\n    width: auto;\n  }\n}\n\n.vg-time-display[_ngcontent-%COMP%]:not(:root:root) {\n  flex: 0 1 auto;\n  width: auto;\n}\n\n.vg-scrub-bar[_ngcontent-%COMP%] {\n  display: flex;\n  width: 25.2777777777778%;\n}\n\n@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {\n  .vg-scrub-bar[_ngcontent-%COMP%] {\n    height: auto;\n  }\n}\n\n.vg-volume[_ngcontent-%COMP%] {\n  margin: 0 0.71428571em;\n  width: 11.1111111111111%;\n}\n\n.vg-volume[_ngcontent-%COMP%]   .volumeBackground[_ngcontent-%COMP%] {\n  background-color: #232323;\n  height: 0.14285714em;\n}\n\n.vg-volume[_ngcontent-%COMP%]   .volumeValue[_ngcontent-%COMP%] {\n  background-color: #2E2B71;\n  height: 0.14285714em;\n}\n\n.vg-volume[_ngcontent-%COMP%]   .volumeKnob[_ngcontent-%COMP%] {\n  background-color: #2E2B71;\n  height: 0.85714286em;\n  width: 0.85714286em;\n}\n\n.vg-full-width[_ngcontent-%COMP%] {\n  margin: 0 0.71428571em;\n}\n\n@media screen and (max-width: 768px) {\n  .vg-volume-speaker[_ngcontent-%COMP%], .vg-volume[_ngcontent-%COMP%], .vg-full-width[_ngcontent-%COMP%] {\n    display: none;\n  }\n}\n\n*[_ngcontent-%COMP%]::-webkit-media-controls-panel {\n  display: none !important;\n  -webkit-appearance: none;\n}\n\n*[_ngcontent-%COMP%]::-webkit-media-controls-start-playback-button {\n  display: none !important;\n  -webkit-appearance: none;\n}\n\n*[_ngcontent-%COMP%]::--webkit-media-controls-play-button {\n  display: none !important;\n  -webkit-appearance: none;\n}\n\n@media screen and (width: 768px) {\n  .col-sm-5[_ngcontent-%COMP%], .col-sm-7[_ngcontent-%COMP%] {\n    width: 100%;\n  }\n}\n\n@media screen and (max-width: 768px) {\n  .full-width-mobile[_ngcontent-%COMP%] {\n    margin-top: -2.85714286em;\n    padding: 0;\n  }\n}\n\n.selected[_ngcontent-%COMP%] {\n  background-color: rgba(45, 133, 211, 0.3);\n  color: black;\n}\n\n.row--top[_ngcontent-%COMP%] {\n  display: flex;\n  margin-bottom: 30px;\n}\n\n.row--top[_ngcontent-%COMP%]   .col-left[_ngcontent-%COMP%] {\n  display: flex;\n  flex-direction: column;\n}\n\n.row--top[_ngcontent-%COMP%]   .page-title[_ngcontent-%COMP%] {\n  flex: 2;\n}\n\n.row--top[_ngcontent-%COMP%]   .button-bar[_ngcontent-%COMP%] {\n  margin: 0;\n}\n\n.search__links-container[_ngcontent-%COMP%] {\n  margin-bottom: 0;\n}\n\n.search__routerLink[_ngcontent-%COMP%] {\n  margin-bottom: 0;\n}\n\n.search--desktop[_ngcontent-%COMP%] {\n  margin-bottom: 0;\n}\n\n.button-bar[_ngcontent-%COMP%] {\n  align-items: center;\n  display: flex;\n  margin-top: 1.14285714em;\n  margin-bottom: 0.5em;\n}\n\n.video-header[_ngcontent-%COMP%] {\n  background-color: #232323;\n  color: #fff;\n  font-size: 1.28571429rem;\n  letter-spacing: -.5px;\n  line-height: 1.22222222em;\n  margin-bottom: 0;\n  padding: .5rem 1rem;\n  text-transform: uppercase;\n}\n\n.video-header__category[_ngcontent-%COMP%] {\n  text-transform: capitalize;\n}\n\n.video-title[_ngcontent-%COMP%] {\n  display: inline-block;\n}\n\n.video-container[_ngcontent-%COMP%] {\n  margin-bottom: 2.14285714rem;\n}\n\n.videoBlock[_ngcontent-%COMP%] {\n  display: block;\n  margin: 0 auto;\n  max-width: 320px;\n  \n  min-height: 180px;\n  height: auto;\n  -o-object-fit: fill;\n     object-fit: fill;\n}\n\n.no-padding[_ngcontent-%COMP%] {\n  padding: 0;\n}\n\n.no-left-padding[_ngcontent-%COMP%] {\n  padding-left: 0;\n}\n\n.no-right-padding[_ngcontent-%COMP%] {\n  padding-right: 0;\n}\n\n.about[_ngcontent-%COMP%] {\n  \n  padding: 2.64285714em 0;\n  margin-bottom: 0.5em;\n}\n\n.about--mobile[_ngcontent-%COMP%] {\n  display: none;\n  padding: 1em 0;\n}\n\n@media screen and (max-width: 769px) {\n  .about--mobile-active[_ngcontent-%COMP%] {\n    display: inherit;\n  }\n}\n\n.about[_ngcontent-%COMP%]   p[_ngcontent-%COMP%]:last-of-type {\n  margin-bottom: 0;\n}\n\n.about__section[_ngcontent-%COMP%] {\n  border-bottom: 1px solid #cccccc;\n  margin-bottom: 0.71428571em;\n  padding-bottom: 0.85714286em;\n}\n\n@media screen and (min-width: 768px) {\n  .about__section[_ngcontent-%COMP%] {\n    margin-bottom: 1.14285714em;\n    padding-bottom: 1.14285714em;\n  }\n}\n\n.about__section[_ngcontent-%COMP%]:first-of-type {\n  margin-top: 1.57142857em;\n}\n\n@media screen and (min-width: 768px) {\n  .about__section[_ngcontent-%COMP%]:first-of-type {\n    margin-top: 0;\n  }\n}\n\n.about__section[_ngcontent-%COMP%]:last-of-type {\n  border-bottom: 0;\n}\n\n.about__heading[_ngcontent-%COMP%] {\n  color: #232323;\n  font-size: 1.14285714em;\n  letter-spacing: -.4px;\n  line-height: 1.25em;\n  text-transform: uppercase;\n}\n\n.about__copy--favorites[_ngcontent-%COMP%] {\n  margin: 0;\n}\n\n.about__link[_ngcontent-%COMP%], .about__link[_ngcontent-%COMP%]:visited {\n  color: #2E2B71;\n}\n\n.transcriptTextArea[_ngcontent-%COMP%] {\n  display: inline;\n}\n\n.shadowview[_ngcontent-%COMP%] {\n  width: 50%;\n  box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.75);\n  margin-top: 2px;\n  margin-bottom: 6px;\n}\n\n.storyduration[_ngcontent-%COMP%] {\n  text-align: center;\n  color: #1E1810;\n  font-size: 0.9em;\n  line-height: 0.95em;\n  margin-top: 0.4em;\n}\n\n.bumpUp[_ngcontent-%COMP%] {\n  margin-top: 0.0em;\n  margin-bottom: 0.3em;\n  margin-right: 0em;\n  margin-left: 0em;\n}\n\ninput[_ngcontent-%COMP%] {\n  color: #1E1810;\n  font-family: 'Roboto', sans-serif;\n  font-weight: 300;\n  font-size: 1em;\n}\n\n.page-title[_ngcontent-%COMP%] {\n  color: #232323;\n  font-size: 1.28571429rem;\n  letter-spacing: -.5px;\n  text-transform: uppercase;\n}\n\n@media screen and (min-width: 768px) {\n  .page-title[_ngcontent-%COMP%] {\n    font-size: 1.57142857rem;\n    letter-spacing: -.42px;\n  }\n}\n\n@media screen and (min-width: 1200px) {\n  .page-title[_ngcontent-%COMP%] {\n    font-size: 1.85714286rem;\n    letter-spacing: -.5px;\n  }\n}\n\n.transcript[_ngcontent-%COMP%] {\n  display: none;\n  line-height: 1.28571429em;\n  font-size: 0.85714286rem;\n  margin-bottom: 1.42857143em;\n  margin-top: 1.42857143em;\n  position: relative;\n}\n\n@media screen and (min-width: 769px) {\n  .transcript[_ngcontent-%COMP%] {\n    background-color: #dedede;\n    border: 1px solid #cccccc;\n    display: inherit;\n    line-height: 1.375em;\n    font-size: 1.14285714rem;\n    padding: 1em;\n    margin-bottom: 1.25em;\n    margin-top: 0em;\n  }\n}\n\n.transcript--mobile-active[_ngcontent-%COMP%] {\n  display: inherit;\n}\n\n.back-button[_ngcontent-%COMP%] {\n  align-items: center;\n  background-color: transparent;\n  color: #2E2B71;\n  display: inline-flex;\n  font-size: 1.28571429rem;\n  text-transform: uppercase;\n}\n\n.back-button--mobile[_ngcontent-%COMP%] {\n  margin-bottom: 0.66666667em;\n}\n\n.back-button__chevron[_ngcontent-%COMP%] {\n  margin-right: 0.27777778em;\n}\n\n.playlist-button[_ngcontent-%COMP%] {\n  align-items: center;\n  background-color: #941A1D;\n  border-radius: 0;\n  color: #fff;\n  cursor: pointer;\n  display: inline-flex;\n  font-size: 1.25em;\n  height: 2.6875em;\n  justify-content: center;\n  letter-spacing: .5px;\n  text-transform: uppercase;\n  transition: box-shadow .15s ease-in-out;\n  width: 100%;\n}\n\n@media screen and (min-width: 544px) {\n  .playlist-button[_ngcontent-%COMP%] {\n    font-size: 1.14285714em;\n    margin-left: 0.71428571em;\n    width: auto;\n  }\n}\n\n@media screen and (min-width: 1200px) {\n  .playlist-button[_ngcontent-%COMP%] {\n    order: initial;\n  }\n}\n\n.playlist-button[_ngcontent-%COMP%]:hover {\n  box-shadow: inset 0 0 5px rgba(51, 51, 51, 0.6);\n}\n\n.playlist-button[_ngcontent-%COMP%]:disabled {\n  cursor: not-allowed;\n  opacity: .4;\n}\n\n.playlist-button--mobile[_ngcontent-%COMP%] {\n  margin-bottom: 0.66666667em;\n}\n\n.playlist-button[_ngcontent-%COMP%]   svg[_ngcontent-%COMP%] {\n  margin-left: 0.57142857em;\n  vertical-align: text-top;\n}\n\n.playlist[_ngcontent-%COMP%] {\n  background-color: #941A1D;\n  color: #fff;\n  font-size: 1rem;\n  min-height: 10.71428571em;\n  padding: 1.07142857em;\n  width: 100%;\n}\n\n.playlist__title-row[_ngcontent-%COMP%] {\n  align-items: center;\n  display: flex;\n}\n\n.playlist__title[_ngcontent-%COMP%] {\n  font-size: 1.5em;\n  letter-spacing: -.5px;\n  text-transform: uppercase;\n}\n\n@media screen and (min-width: 1200px) {\n  .playlist__title[_ngcontent-%COMP%] {\n    font-size: 1.57142857em;\n  }\n}\n\n.playlist__link[_ngcontent-%COMP%] {\n  cursor: pointer;\n  margin-left: auto;\n}\n\n.playlist__total[_ngcontent-%COMP%] {\n  color: #fff;\n  font-size: 1.14285714em;\n  margin-left: 0.35714286em;\n  margin-top: 0.35714286em;\n}\n\n.playlist__item[_ngcontent-%COMP%] {\n  display: flex;\n  margin-bottom: 0.71428571em;\n}\n\n.playlist__item-desc[_ngcontent-%COMP%] {\n  background-color: #f0f0f0;\n  color: #232323;\n  flex: 1;\n  font-size: 0.71428571em;\n  padding: 0.7em 1em;\n}\n\n@media screen and (min-width: 1200px) {\n  .playlist__item-desc[_ngcontent-%COMP%] {\n    font-size: 0.85714286em;\n    padding: 0.58333333em 0.83333333em;\n  }\n}\n\n.match[_ngcontent-%COMP%] {\n  background-color: #2E2B71;\n  display: flex;\n  height: 2.14285714em;\n  position: relative;\n}\n\n.match__prev[_ngcontent-%COMP%], .match__next[_ngcontent-%COMP%] {\n  background-color: transparent;\n  color: black;\n  display: flex;\n}\n\n.match__prev-button[_ngcontent-%COMP%], .match__next-button[_ngcontent-%COMP%] {\n  align-items: center;\n  background-color: transparent;\n  color: #fff;\n  display: flex;\n}\n\n.match__prev-button[_ngcontent-%COMP%]   .match__copy[_ngcontent-%COMP%] {\n  margin-left: 5px;\n}\n\n.match__next-button[_ngcontent-%COMP%]   .match__copy[_ngcontent-%COMP%] {\n  margin-right: 5px;\n}\n\n.match__tick-line[_ngcontent-%COMP%] {\n  background-color: #cccccc;\n  flex: 1;\n  position: relative;\n  height: 2px;\n  margin: auto 0;\n}\n\n.match__tick[_ngcontent-%COMP%] {\n  background-color: #fff;\n  height: 1.07142857em;\n  margin: 0em 0em 0em 0em;\n  padding: 0em 0em 0em 0em;\n  position: absolute;\n  top: -7px;\n  width: 2px;\n}\n\n.story-nav[_ngcontent-%COMP%] {\n  background-color: #232323;\n  display: flex;\n  height: 2.14285714em;\n  justify-content: space-between;\n}\n\n@media screen and (min-width: 769px) {\n  .story-nav[_ngcontent-%COMP%] {\n    background-color: transparent;\n  }\n}\n\n.story-nav__prev[_ngcontent-%COMP%], .story-nav__next[_ngcontent-%COMP%] {\n  display: flex;\n}\n\n.story-nav__prev-button[_ngcontent-%COMP%], .story-nav__next-button[_ngcontent-%COMP%] {\n  align-items: center;\n  background-color: transparent;\n  color: #fff;\n  display: flex;\n}\n\n@media screen and (min-width: 769px) {\n  .story-nav__prev-button[_ngcontent-%COMP%], .story-nav__next-button[_ngcontent-%COMP%] {\n    color: #232323;\n  }\n}\n\n.story-nav__prev-button[_ngcontent-%COMP%]   .story-nav__copy[_ngcontent-%COMP%] {\n  margin-left: 5px;\n}\n\n.story-nav__next-button[_ngcontent-%COMP%]   .story-nav__copy[_ngcontent-%COMP%] {\n  margin-right: 5px;\n}\n\n.wideScreen[_ngcontent-%COMP%] {\n  margin-bottom: 20px;\n  width: 100% !important;\n}\n\n.wideScreen[_ngcontent-%COMP%]   .about[_ngcontent-%COMP%] {\n  display: none;\n}\n\n.tabs[_ngcontent-%COMP%] {\n  align-items: center;\n  border-bottom: 1px solid #cccccc;\n  display: flex;\n  font-size: 1.14285714rem;\n  margin: 0.875em 0.9375em 0;\n}\n\n@media screen and (width: 768px) {\n  .tabs[_ngcontent-%COMP%] {\n    float: left;\n    margin: 0.875em 0 0;\n    width: 100%;\n  }\n}\n\n.tabs__tab[_ngcontent-%COMP%] {\n  background-color: #f0f0f0;\n  color: #cccccc;\n  padding: 0.8125em 0.625em;\n  text-transform: uppercase;\n}\n\n.tabs__tab[_ngcontent-%COMP%]:hover {\n  cursor: pointer;\n}\n\n.tabs__tab--active[_ngcontent-%COMP%] {\n  background-color: #941A1D;\n  color: #fff;\n}\n\n.tabs__add-story[_ngcontent-%COMP%] {\n  margin-left: auto;\n}\n\n.tabs__playlist-buttons[_ngcontent-%COMP%] {\n  margin-left: auto;\n}\n\n.tabs__playlist-buttons[_ngcontent-%COMP%] {\n  align-items: center;\n  display: flex;\n  height: 2.5em;\n  justify-content: center;\n  position: relative;\n  width: 2.5em;\n}\n\n.tabs__tooltip[_ngcontent-%COMP%] {\n  font-size: 0.85714286rem;\n  position: absolute;\n  right: 3.33333333em;\n  background: #941A1D;\n  color: white;\n  text-align: center;\n  padding: 0.66666667em;\n  top: 0;\n  border-radius: 0.25em;\n  white-space: nowrap;\n}\n\n.tabs__tooltip[_ngcontent-%COMP%]::before {\n  border-bottom: 5px solid transparent;\n  border-left: 5px solid #941A1D;\n  border-top: 5px solid transparent;\n  content: \" \";\n  height: 0;\n  position: absolute;\n  right: -0.33333333em;\n  top: 1.08333333em;\n  width: 0;\n  white-space: nowrap;\n}\n\n.adjust-height[_ngcontent-%COMP%] {\n  overflow-x: hidden;\n  overflow-y: auto;\n}\n\n.next-vid__row[_ngcontent-%COMP%] {\n  display: flex;\n}\n\n.next-vid__row[_ngcontent-%COMP%]:hover {\n  cursor: pointer;\n}\n\n.video__title[_ngcontent-%COMP%], .next-vid__title[_ngcontent-%COMP%] {\n  color: #941A1D;\n  font-weight: 700;\n}\n\n.video__title[_ngcontent-%COMP%] {\n  font-size: 1.28571429rem;\n}\n\n.next-vid__preview[_ngcontent-%COMP%]:hover {\n  cursor: pointer;\n}\n\n.next-vid__thumb[_ngcontent-%COMP%] {\n  font-size: 1rem;\n  max-width: 100%;\n}\n\n.next-vid__da-button[_ngcontent-%COMP%] {\n  background-color: #682052;\n  border: 1px solid transparent;\n  color: #fff;\n  display: block;\n  font-size: 1.78571429rem;\n  font-weight: 400;\n  line-height: 1.2;\n  padding: 0.6em;\n  margin-top: 0.4em;\n  transition: all .2s ease-in-out;\n}\n\n.next-vid__da-button[_ngcontent-%COMP%]:hover {\n  background-color: #fff;\n  border: 1px solid #682052;\n  color: #682052;\n  text-decoration: none;\n}\n/*# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIi4uLy4uL2FwcC5jb21wb25lbnQuc2NzcyIsIi4uLy4uL3NoYXJlZC90aGVtZS9fdmFyaWFibGVzLnNjc3MiLCIuLi8uLi9zaGFyZWQvdGhlbWUvX2Z1bmN0aW9ucy5zY3NzIiwiLi4vLi4vc2hhcmVkL3RoZW1lL19oZWxwZXJzLnNjc3MiLCIuLi8uLi9zaGFyZWQvdGhlbWUvX2Jhc2Uuc2NzcyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiQUFraUJBOzs7RUM5Z0JFLDBDQUEwQztBRGhCNUM7O0FBb1RBOztFQ2hTRSwwQ0FBMEM7RUFDMUMsZ0JBQWdCO0FEZmxCOztBQThlQTtFQzNkRSwwQ0FBMEM7RUFDMUMsa0JBQWtCO0VBQ2xCLGdCQUFnQjtBRGZsQjs7QUFxbkJBO0VDbG1CRSwwQ0FBMEM7RUFDMUMsZ0JBQWdCO0FEZmxCOztBQ3dCQTtFQUNFLGlDQUFpQztFQUNqQyxnQkFBZ0I7QURyQmxCOztBQ21DQTtFQUVJLGNBakRnQjtFQWtEaEIscUJBQXFCO0VBQ3JCLHNCQUFzQjtFQUN0QixxQkFBcUI7RUFDckIseUJBQXlCO0FEakM3Qjs7QUM2Q0E7RUFFRSxjQW5Fa0I7RUFvRWxCLG9CQUFvQjtFQUNwQixpQkFBaUI7RUFDakIscUJBQXFCO0VBQ3JCLFVBQVU7QUQzQ1o7O0FDd0RBO0VBRUksY0F0RmdCO0VBdUZoQix1QkN4RThCO0VEeUU5QixnQkFBZ0I7RUFDaEIsYUFBYTtFQUNiLHlCQUF5QjtFQUN6QixjQUFjO0FEdERsQjs7QUNpRUE7RUFFSSxjQXhHZ0I7RUF5R2hCLHVCQzFGOEI7RUQyRjlCLGlCQUFpQjtFQUNqQixVQUFVO0FEL0RkOztBR3JEQTtFQUNRLGdCQUFnQjtBSHdEeEI7O0FHdERBO0VBQ1Usa0JBQWtCO0FIeUQ1Qjs7QUd2REE7RUFFRSxxQkFBcUI7RUFDckIsVUFBVTtBSDBEWjs7QUdyREU7RUhpTEY7O0lHaExJLHdCQUF3QjtFSDBEMUI7QUFDRjs7QUdyREU7O0VBRkY7SUFHSSx3QkFBd0I7RUgwRDFCO0FBQ0Y7O0FHckRFO0VI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QjtFQUNsQixZRXRvQjhCO0FGNHVCbEM7O0FBbkdBO0VBQ0ksd0JFOW5CK0I7RUYrbkIvQixrQkFBa0I7RUFDbEIsbUJFNW9COEI7RUY2b0I5QixtQkNocUJnQjtFRGlxQmhCLFlBQVk7RUFDWixrQkFBa0I7RUFDbEIscUJFaHBCOEI7RUZpcEI5QixNQUFNO0VBQ04scUJFbHBCOEI7RUZtcEI5QixtQkFBbUI7QUFzR3ZCOztBQWhIQTtFQWFRLG9DQUFvQztFQUNwQyw4QkMxcUJZO0VEMnFCWixpQ0FBaUM7RUFDakMsWUFBWTtFQUNaLFNBQVM7RUFDVCxrQkFBa0I7RUFDbEIsb0JFNXBCMEI7RUY2cEIxQixpQkU3cEIwQjtFRjhwQjFCLFFBQVE7RUFDUixtQkFBbUI7QUF1RzNCOztBQW5HQTtFQUNFLGtCQUFrQjtFQUNsQixnQkFBZ0I7QUFzR2xCOztBQW5HQTtFQUNFLGFBQWE7QUFzR2Y7O0FBdkdBO0VBSUksZUFBZTtBQXVHbkI7O0FBbkdBOztFQUVFLGNDcnNCa0I7RURzc0JsQixnQkFBZ0I7QUFzR2xCOztBQW5HQTtFQUFnQix3QkUxcUJtQjtBRml4Qm5DOztBQXJHQTtFQUNFLGVBQWU7QUF3R2pCOztBQXJHQTtFQUNFLGVFanJCaUM7RUZrckJqQyxlQUFlO0FBd0dqQjs7QUFyR0E7RUFFRSx5QkFBeUI7RUFDekIsNkJBQTZCO0VBQzdCLFdBQVc7RUFDWCxjQUFjO0VBQ2Qsd0JFM3JCaUM7RUY0ckJqQyxnQkFBZ0I7RUFDaEIsZ0JBQWdCO0VBQ2hCLGNFMXNCZ0M7RUYyc0JoQyxpQkUzc0JnQztFRjRzQmhDLCtCQUErQjtBQXVHakM7O0FBbEhBO0VBY0ksc0JBQXNCO0VBQ3RCLHlCQUF5QjtFQUN6QixjQUFjO0VBQ2QscUJBQXFCO0FBd0d6QiIsImZpbGUiOiJhcHAuY29tcG9uZW50LnNjc3MiLCJzb3VyY2VzQ29udGVudCI6WyJAaW1wb3J0ICcuL3NoYXJlZC90aGVtZS9iYXNlJztcblxudmlkZW8ge1xuICBtYXgtd2lkdGg6IDUwMHB4O1xuICBtYXJnaW46IDAgYXV0bztcbn1cblxudmctcGxheWVyW19uZ2NvbnRlbnQtYzBdIHtcbiAgaGVpZ2h0OiBhdXRvO1xuICBwYWRkaW5nLWJvdHRvbTogMzRweDtcbn1cblxuLnZnLWNvbnRyb2xzIHtcbiAgYWxpZ24taXRlbXM6IGNlbnRlcjtcbiAgYmFja2dyb3VuZC1jb2xvcjogY29sb3IoZ3JleSk7XG4gIGhlaWdodDogZW0oMzApO1xufVxuXG4udmctY29udHJvbHNfX2lubmVyLXdyYXBwZXIge1xuICBhbGlnbi1pdGVtczogY2VudGVyO1xuICBkaXNwbGF5OiBmbGV4O1xuICBmbGV4OiAyO1xuICBtYXJnaW46IDAgYXV0bztcbiAgbWF4LXdpZHRoOiBlbSg1MDApO1xuXG4gIC8vSUVcbiAgQG1lZGlhIHNjcmVlbiBhbmQgKC1tcy1oaWdoLWNvbnRyYXN0OiBhY3RpdmUpLCAoLW1zLWhpZ2gtY29udHJhc3Q6IG5vbmUpIHtcbiAgICBtYXgtd2lkdGg6IDEwMCU7XG4gIH1cbn1cblxuLnZnLXBsYXktcGF1c2UgeyB3aWR0aDogZW0oMzApOyB9XG5cbi52Zy1zY3J1Yi1iYXItY3VycmVudC10aW1lIHtcbiAgYWxpZ24taXRlbXM6IGNlbnRlcjtcbiAgYmFja2dyb3VuZC1jb2xvcjogY29sb3IoZGFyay1ncmV5KTtcbiAgaGVpZ2h0OiBlbSgyKTtcbiAgcG9zaXRpb246IHJlbGF0aXZlO1xuICB0b3A6IGluaXRpYWw7XG5cbiAgLmJhY2tncm91bmQge1xuICAgIGJvcmRlcjogMXB4IHNvbGlkIGNvbG9yKHByaW1hcnkpO1xuICB9XG5cbiAgLnNsaWRlciB7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogY29sb3IocHJpbWFyeSk7XG4gICAgYm94LXNoYWRvdzogbm9uZTtcbiAgICBoZWlnaHQ6IGVtKDEyKTtcbiAgICBtYXJnaW4tdG9wOiAwO1xuICAgIHdpZHRoOiBlbSgxMik7XG4gIH1cbn1cblxuLnZnLXBsYXktcGF1c2UsXG4udmctdGltZS1kaXNwbGF5LFxuLnZnLXNjcnViLWJhcixcbi52Zy12b2x1bWUge1xuICBhbGlnbi1pdGVtczogY2VudGVyO1xuICBjb2xvcjogY29sb3IoZGFyay1ncmV5KTtcbiAgaGVpZ2h0OiBlbSgzMCk7XG59XG5cbi52Zy10aW1lLWRpc3BsYXkge1xuICBmbGV4OiAwO1xuICBtYXJnaW46IDAgZW0oNSk7XG5cbiAgLy9JRVxuICBAbWVkaWEgc2NyZWVuIGFuZCAoLW1zLWhpZ2gtY29udHJhc3Q6IGFjdGl2ZSksICgtbXMtaGlnaC1jb250cmFzdDogbm9uZSkge1xuICAgIGZsZXg6IDAgMSBhdXRvO1xuICAgIHdpZHRoOiBhdXRvO1xuICB9XG5cbiAgLy9TYWZhcmlcbiAgJjpub3QoOnJvb3Q6cm9vdCkge1xuICAgIGZsZXg6IDAgMSBhdXRvO1xuICAgIHdpZHRoOiBhdXRvO1xuICB9XG59XG5cbi52Zy1zY3J1Yi1iYXIge1xuICBkaXNwbGF5OiBmbGV4O1xuICB3aWR0aDogMjUuMjc3Nzc3Nzc3Nzc3OCU7XG5cbiAgLy9JRVxuICBAbWVkaWEgc2NyZWVuIGFuZCAoLW1zLWhpZ2gtY29udHJhc3Q6IGFjdGl2ZSksICgtbXMtaGlnaC1jb250cmFzdDogbm9uZSkge1xuICAgIGhlaWdodDogYXV0bztcbiAgfVxufVxuXG4udmctdm9sdW1lIHtcbiAgbWFyZ2luOiAwIGVtKDEwKTtcbiAgd2lkdGg6IDExLjExMTExMTExMTExMTElO1xufVxuXG4udmctdm9sdW1lIC52b2x1bWVCYWNrZ3JvdW5kIHtcbiAgYmFja2dyb3VuZC1jb2xvcjogY29sb3IoZGFyay1ncmV5KTtcbiAgaGVpZ2h0OiBlbSgyKTtcbn1cblxuLnZnLXZvbHVtZSAudm9sdW1lVmFsdWUge1xuICBiYWNrZ3JvdW5kLWNvbG9yOiBjb2xvcihwcmltYXJ5KTtcbiAgaGVpZ2h0OiBlbSgyKVxufVxuXG4udmctdm9sdW1lIC52b2x1bWVLbm9iIHtcbiAgYmFja2dyb3VuZC1jb2xvcjogY29sb3IocHJpbWFyeSk7XG4gIGhlaWdodDogZW0oMTIpO1xuICB3aWR0aDogZW0oMTIpO1xufVxuXG4udmctZnVsbC13aWR0aCB7XG4gIG1hcmdpbjogMCBlbSgxMCk7XG59XG5cbi52Zy12b2x1bWUtc3BlYWtlcixcbi52Zy12b2x1bWUsXG4udmctZnVsbC13aWR0aCB7XG4gIEBtZWRpYSBzY3JlZW4gYW5kIChtYXgtd2lkdGg6IGJwKG1lZGl1bSkpIHtcbiAgICBkaXNwbGF5OiBub25lO1xuICB9XG59XG5cblxuKjo6LXdlYmtpdC1tZWRpYS1jb250cm9scy1wYW5lbCB7XG4gIGRpc3BsYXk6IG5vbmUhaW1wb3J0YW50O1xuICAtd2Via2l0LWFwcGVhcmFuY2U6IG5vbmU7XG59XG5cbio6Oi13ZWJraXQtbWVkaWEtY29udHJvbHMtc3RhcnQtcGxheWJhY2stYnV0dG9uIHtcbiAgZGlzcGxheTogbm9uZSFpbXBvcnRhbnQ7XG4gIC13ZWJraXQtYXBwZWFyYW5jZTogbm9uZTtcbn1cblxuKjo6LS13ZWJraXQtbWVkaWEtY29udHJvbHMtcGxheS1idXR0b24ge1xuICBkaXNwbGF5OiBub25lIWltcG9ydGFudDtcbiAgLXdlYmtpdC1hcHBlYXJhbmNlOiBub25lO1xufVxuXG4vLyBzdG9yeSBzdHlsZXNcbi5jb2wtc20tNSxcbi5jb2wtc20tNyB7XG4gICAgQG1lZGlhIHNjcmVlbiBhbmQgKHdpZHRoOiA3NjhweCkge1xuICAgICAgICB3aWR0aDogMTAwJTtcbiAgICB9XG59XG5cbi5mdWxsLXdpZHRoLW1vYmlsZSB7XG5cbiAgICBAbWVkaWEgc2NyZWVuIGFuZCAobWF4LXdpZHRoOiBicChtZWRpdW0pKSB7XG4gICAgICAgIG1hcmdpbi10b3A6IC0gZW0oNDApO1xuICAgICAgICBwYWRkaW5nOiAwO1xuICAgIH1cbn1cblxuLnNlbGVjdGVkIHtcbiAgICBiYWNrZ3JvdW5kLWNvbG9yOiByZ2JhKDQ1LDEzMywyMTEsLjMpO1xuICAgIGNvbG9yOiBibGFjaztcbn1cblxuLnJvdy0tdG9wIHtcbiAgICBkaXNwbGF5OiBmbGV4O1xuICAgIG1hcmdpbi1ib3R0b206IDMwcHg7XG5cbiAgICAuY29sLWxlZnQge1xuICAgICAgICBkaXNwbGF5OiBmbGV4O1xuICAgICAgICBmbGV4LWRpcmVjdGlvbjogY29sdW1uO1xuICAgIH1cblxuICAgIC5wYWdlLXRpdGxlIHtcbiAgICAgICAgZmxleDogMjtcbiAgICB9XG5cbiAgICAuYnV0dG9uLWJhciB7XG4gICAgICAgIG1hcmdpbjogMDtcbiAgICB9XG59XG5cbi5zZWFyY2hfX2xpbmtzLWNvbnRhaW5lciB7XG4gICAgbWFyZ2luLWJvdHRvbTogMDtcbn1cblxuLnNlYXJjaF9fcm91dGVyTGluayB7XG4gICAgbWFyZ2luLWJvdHRvbTogMDtcbn1cblxuLnNlYXJjaC0tZGVza3RvcCB7XG4gICAgbWFyZ2luLWJvdHRvbTogMDtcbn1cblxuLmJ1dHRvbi1iYXIge1xuICAgIGFsaWduLWl0ZW1zOiBjZW50ZXI7XG4gICAgZGlzcGxheTogZmxleDtcbiAgICBtYXJnaW4tdG9wOiBlbSgxNik7XG4gICAgbWFyZ2luLWJvdHRvbTogMC41ZW07XG59XG5cbi52aWRlby1oZWFkZXIge1xuICAgIEBleHRlbmQgJW9zd2FsZDtcbiAgICBAZXh0ZW5kICVtb2JpbGUtb25seTtcblxuICAgIGJhY2tncm91bmQtY29sb3I6IGNvbG9yKGRhcmstZ3JleSk7XG4gICAgY29sb3I6ICNmZmY7XG4gICAgZm9udC1zaXplOiByZW0oMTgpO1xuICAgIGxldHRlci1zcGFjaW5nOiAtLjVweDtcbiAgICBsaW5lLWhlaWdodDogZW0oMjIsIDE4KTtcbiAgICBtYXJnaW4tYm90dG9tOiAwO1xuICAgIHBhZGRpbmc6IC41cmVtIDFyZW07XG4gICAgdGV4dC10cmFuc2Zvcm06IHVwcGVyY2FzZTtcbn1cblxuLnZpZGVvLWhlYWRlcl9fY2F0ZWdvcnkge1xuICAgIHRleHQtdHJhbnNmb3JtOiBjYXBpdGFsaXplO1xufVxuXG4udmlkZW8tdGl0bGUge1xuICAgIGRpc3BsYXk6IGlubGluZS1ibG9jaztcbn1cblxuLnZpZGVvLWNvbnRhaW5lciB7XG4gICAgbWFyZ2luLWJvdHRvbTogcmVtKDMwKTtcbn1cblxuLnZpZGVvQmxvY2sge1xuICAgIGRpc3BsYXk6YmxvY2s7XG4gICAgbWFyZ2luOiAwIGF1dG87XG4gICAgbWF4LXdpZHRoOiAzMjBweDsgLyogVE9ETzogZGVjaWRlIGlmIHdlIHdhbnQgZ3JlYXRlciB0aGFuIDF4IGRpc3BsYXkgd2lkdGgsIG9yIHN0YXkgYXQgbWF4IDF4IGRpc3BsYXkgd2lkdGggd2hpY2ggaXMgMzIwIHBpeGVscyAqL1xuICAgIG1pbi1oZWlnaHQ6IDE4MHB4O1xuICAgIGhlaWdodDogYXV0bztcbiAgICBvYmplY3QtZml0OiBmaWxsO1xufVxuXG4ubm8tcGFkZGluZyB7XG4gICAgcGFkZGluZzogMDtcbn1cblxuLm5vLWxlZnQtcGFkZGluZyB7XG4gICAgcGFkZGluZy1sZWZ0OiAwO1xufVxuXG4ubm8tcmlnaHQtcGFkZGluZyB7XG4gICAgcGFkZGluZy1yaWdodDogMDtcbn1cblxuLmFib3V0IHtcbiAgICAvKiBUT0RPOiBMYXRlciwgZHJlc3MgdXAgd2l0aCBncmFkaWVudCBiYWNrZ3JvdW5kcywgZS5nLixcbiAgICBiYWNrZ3JvdW5kLWNvbG9yOiB0cmFuc3BhcmVudDtcbiAgICBiYWNrZ3JvdW5kLWltYWdlOiBsaW5lYXItZ3JhZGllbnQodG8gYm90dG9tLCByZ2JhKDMwLCA4NywgMTUzLCAwLjIpIDAlLCByZ2JhKDEyNSwgMTg1LCAyMzIsIDApIDEwMCUpO1xuICAgIGJhY2tncm91bmQtcmVwZWF0OiByZXBlYXQ7XG4gICAgKi9cbiAgICBwYWRkaW5nOiBlbSgzNykgMDtcbiAgICBtYXJnaW4tYm90dG9tOiAwLjVlbTtcblxuICAgICYtLW1vYmlsZSB7XG4gICAgICAgIEBleHRlbmQgJW1vYmlsZS1vbmx5O1xuXG4gICAgICAgIGRpc3BsYXk6IG5vbmU7XG4gICAgICAgIHBhZGRpbmc6IGVtKDE0KSAwO1xuICAgIH1cblxuICAgICYtLW1vYmlsZS1hY3RpdmUge1xuICAgICAgICBAbWVkaWEgc2NyZWVuIGFuZCAobWF4LXdpZHRoOiBicChtZWRpdW0pICsgMSkge1xuICAgICAgICAgICAgZGlzcGxheTogaW5oZXJpdDtcbiAgICAgICAgfVxuICAgIH1cblxuICAgICYtLWRlc2t0b3Age1xuICAgICAgICBAZXh0ZW5kICVkZXNrdG9wLW9ubHk7XG4gICAgfVxuXG4gICAgcDpsYXN0LW9mLXR5cGUge1xuICAgICAgICBtYXJnaW4tYm90dG9tOiAwO1xuICAgIH1cbn1cblxuLmFib3V0X19zZWN0aW9uIHtcbiAgICBib3JkZXItYm90dG9tOiAxcHggc29saWQgY29sb3IoZ3JleSk7XG4gICAgbWFyZ2luLWJvdHRvbTogZW0oMTApO1xuICAgIHBhZGRpbmctYm90dG9tOiBlbSgxMik7XG5cbiAgICBAbWVkaWEgc2NyZWVuIGFuZCAobWluLXdpZHRoOiBicChtZWRpdW0pKSB7XG4gICAgICAgIG1hcmdpbi1ib3R0b206IGVtKDE2KTtcbiAgICAgICAgcGFkZGluZy1ib3R0b206IGVtKDE2KTtcbiAgICB9XG5cbiAgICAmOmZpcnN0LW9mLXR5cGUge1xuICAgICAgICBtYXJnaW4tdG9wOiBlbSgyMik7XG5cbiAgICAgICAgQG1lZGlhIHNjcmVlbiBhbmQgKG1pbi13aWR0aDogYnAobWVkaXVtKSkge1xuICAgICAgICAgICAgbWFyZ2luLXRvcDogMDtcbiAgICAgICAgfVxuICAgIH1cblxuICAgICY6bGFzdC1vZi10eXBlIHtcbiAgICAgICAgYm9yZGVyLWJvdHRvbTogMDtcbiAgICB9XG59XG5cbi5hYm91dF9faGVhZGluZyB7XG4gICAgQGV4dGVuZCAlb3N3YWxkO1xuXG4gICAgY29sb3I6IGNvbG9yKGRhcmstZ3JleSk7XG4gICAgZm9udC1zaXplOiBlbSgxNik7XG4gICAgbGV0dGVyLXNwYWNpbmc6IC0uNHB4O1xuICAgIGxpbmUtaGVpZ2h0OiBlbSgyMCwxNik7XG4gICAgdGV4dC10cmFuc2Zvcm06IHVwcGVyY2FzZTtcblxufVxuXG4uYWJvdXRfX2NvcHktLWZhdm9yaXRlcyB7XG4gICAgbWFyZ2luOiAwO1xufVxuXG4uYWJvdXRfX2xpbmssXG4uYWJvdXRfX2xpbms6dmlzaXRlZCB7XG4gICAgQGV4dGVuZCAlc291cmNlLXNhbnMtc2VtaS1ib2xkO1xuICAgIGNvbG9yOiBjb2xvcihwcmltYXJ5KTtcbn1cblxuLnRyYW5zY3JpcHRUZXh0QXJlYSB7XG4gICAgZGlzcGxheTogaW5saW5lO1xufVxuXG4uc2hhZG93dmlldyB7XG4gICAgd2lkdGg6IDUwJTtcbiAgICBib3gtc2hhZG93OiAycHggMnB4IDVweCByZ2JhKDAsMCwwLDAuNzUpO1xuICAgIG1hcmdpbi10b3A6IDJweDtcbiAgICBtYXJnaW4tYm90dG9tOiA2cHg7XG59XG4uc3RvcnlkdXJhdGlvbiB7XG4gICAgdGV4dC1hbGlnbjogY2VudGVyO1xuICAgIGNvbG9yOiAjMUUxODEwO1xuICAgIGZvbnQtc2l6ZTogMC45ZW07XG4gICAgbGluZS1oZWlnaHQ6IDAuOTVlbTtcbiAgICBtYXJnaW4tdG9wOiAwLjRlbTtcbn1cbi5idW1wVXAge1xuICAgIG1hcmdpbi10b3A6IDAuMGVtO1xuICAgIG1hcmdpbi1ib3R0b206IDAuM2VtO1xuICAgIG1hcmdpbi1yaWdodDogMGVtO1xuICAgIG1hcmdpbi1sZWZ0OiAwZW07XG59XG5cbmlucHV0IHtcbiAgICBjb2xvcjogIzFFMTgxMDtcbiAgICBmb250LWZhbWlseTogJ1JvYm90bycsIHNhbnMtc2VyaWY7XG4gICAgZm9udC13ZWlnaHQ6IDMwMDtcbiAgICBmb250LXNpemU6IDFlbTtcbn1cblxuLnBhZ2UtdGl0bGUge1xuICAgIEBleHRlbmQgJW9zd2FsZDtcbiAgICBAZXh0ZW5kICVkZXNrdG9wLW9ubHk7XG5cbiAgICBjb2xvcjogY29sb3IoZGFyay1ncmV5KTtcbiAgICBmb250LXNpemU6IHJlbSgxOCk7XG4gICAgbGV0dGVyLXNwYWNpbmc6IC0uNXB4O1xuICAgIHRleHQtdHJhbnNmb3JtOiB1cHBlcmNhc2U7XG5cbiAgICBAbWVkaWEgc2NyZWVuIGFuZCAobWluLXdpZHRoOiBicChtZWRpdW0pKSB7XG4gICAgICAgIGZvbnQtc2l6ZTogcmVtKDIyKTtcbiAgICAgICAgbGV0dGVyLXNwYWNpbmc6IC0uNDJweDtcbiAgICB9XG5cbiAgICBAbWVkaWEgc2NyZWVuIGFuZCAobWluLXdpZHRoOiBicChsYXJnZSkpIHtcbiAgICAgICAgZm9udC1zaXplOiByZW0oMjYpO1xuICAgICAgICBsZXR0ZXItc3BhY2luZzogLS41cHg7XG4gICAgfVxufVxuXG4udHJhbnNjcmlwdCB7XG4gICAgZGlzcGxheTogbm9uZTtcbiAgICBsaW5lLWhlaWdodDogZW0oMTgpO1xuICAgIGZvbnQtc2l6ZTogcmVtKDEyKTtcbiAgICBtYXJnaW4tYm90dG9tOiBlbSgyMCk7XG4gICAgbWFyZ2luLXRvcDogZW0oMjApO1xuICAgIHBvc2l0aW9uOiByZWxhdGl2ZTtcblxuICAgIEBtZWRpYSBzY3JlZW4gYW5kIChtaW4td2lkdGg6IGJwKG1lZGl1bSkgKyAxKSB7XG4gICAgICAgIGJhY2tncm91bmQtY29sb3I6ICNkZWRlZGU7XG4gICAgICAgIGJvcmRlcjogMXB4IHNvbGlkIGNvbG9yKGdyZXkpO1xuICAgICAgICBkaXNwbGF5OiBpbmhlcml0O1xuICAgICAgICBsaW5lLWhlaWdodDogZW0oMjIsIDE2KTtcbiAgICAgICAgZm9udC1zaXplOiByZW0oMTYpO1xuICAgICAgICBwYWRkaW5nOiBlbSgxNiwgMTYpO1xuICAgICAgICBtYXJnaW4tYm90dG9tOiBlbSgyMCwgMTYpO1xuICAgICAgICBtYXJnaW4tdG9wOiBlbSgwKTtcbiAgICB9XG59XG5cbi50cmFuc2NyaXB0LS1tb2JpbGUtYWN0aXZlIHtcbiAgICBkaXNwbGF5OiBpbmhlcml0O1xufVxuXG4uYmFjay1idXR0b24ge1xuICAgIEBleHRlbmQgJW9zd2FsZDtcblxuICAgIGFsaWduLWl0ZW1zOiBjZW50ZXI7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogdHJhbnNwYXJlbnQ7XG4gICAgY29sb3I6IGNvbG9yKHByaW1hcnkpO1xuICAgIGRpc3BsYXk6IGlubGluZS1mbGV4O1xuICAgIGZvbnQtc2l6ZTogcmVtKDE4KTtcbiAgICB0ZXh0LXRyYW5zZm9ybTogdXBwZXJjYXNlO1xuXG4gICAgJi0tbW9iaWxlIHtcbiAgICAgICAgQGV4dGVuZCAlbW9iaWxlLW9ubHk7XG5cbiAgICAgICAgbWFyZ2luLWJvdHRvbTogZW0oMTIsIDE4KTtcbiAgICB9XG5cbiAgICAmLS1kZXNrdG9wIHtcbiAgICAgICAgQGV4dGVuZCAlZGVza3RvcC1vbmx5O1xuICAgIH1cbn1cblxuLmJhY2stYnV0dG9uX19jaGV2cm9uIHtcbiAgICBtYXJnaW4tcmlnaHQ6IGVtKDUsIDE4KTtcbn1cblxuLnBsYXlsaXN0LWJ1dHRvbiB7XG4gICAgQGV4dGVuZCAlc291cmNlLXNhbnMtc2VtaS1ib2xkO1xuICAgIEBleHRlbmQgJWRlc2t0b3Atb25seTtcblxuICAgIGFsaWduLWl0ZW1zOiBjZW50ZXI7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogY29sb3Ioc2Vjb25kYXJ5KTtcbiAgICBib3JkZXItcmFkaXVzOiAwO1xuICAgIGNvbG9yOiAjZmZmO1xuICAgIGN1cnNvcjogcG9pbnRlcjtcbiAgICBkaXNwbGF5OiBpbmxpbmUtZmxleDtcbiAgICBmb250LXNpemU6IGVtKDIwLCAxNik7XG4gICAgaGVpZ2h0OiBlbSg0MywgMTYpO1xuICAgIGp1c3RpZnktY29udGVudDogY2VudGVyO1xuICAgIGxldHRlci1zcGFjaW5nOiAuNXB4O1xuICAgIHRleHQtdHJhbnNmb3JtOiB1cHBlcmNhc2U7XG4gICAgdHJhbnNpdGlvbjogYm94LXNoYWRvdyAuMTVzIGVhc2UtaW4tb3V0O1xuICAgIHdpZHRoOiAxMDAlO1xuXG4gICAgQG1lZGlhIHNjcmVlbiBhbmQgKG1pbi13aWR0aDogYnAoc21hbGwpKSB7XG4gICAgICAgIGZvbnQtc2l6ZTogZW0oMTYpO1xuICAgICAgICBtYXJnaW4tbGVmdDogZW0oMTApO1xuICAgICAgICB3aWR0aDogYXV0bztcbiAgICB9XG5cbiAgICBAbWVkaWEgc2NyZWVuIGFuZCAobWluLXdpZHRoOiBicChsYXJnZSkpIHtcbiAgICAgICAgb3JkZXI6IGluaXRpYWw7XG4gICAgfVxuXG4gICAgJjpob3ZlciB7XG4gICAgICAgIGJveC1zaGFkb3c6IGluc2V0IDAgMCA1cHggcmdiYSg1MSw1MSw1MSwuNik7XG4gICAgfVxuXG4gICAgJjpkaXNhYmxlZCB7XG4gICAgICAgIGN1cnNvcjogbm90LWFsbG93ZWQ7XG4gICAgICAgIG9wYWNpdHk6IC40O1xuICAgIH1cblxuICAgICYtLW1vYmlsZSB7XG4gICAgICAgIEBleHRlbmQgJW1vYmlsZS1vbmx5O1xuXG4gICAgICAgIG1hcmdpbi1ib3R0b206IGVtKDEyLCAxOCk7XG4gICAgfVxuXG4gICAgJi0tZGVza3RvcCB7XG4gICAgICAgIEBleHRlbmQgJWRlc2t0b3Atb25seTtcbiAgICB9XG5cbiAgICBzdmcge1xuICAgICAgICBtYXJnaW4tbGVmdDogZW0oOCk7XG4gICAgICAgIHZlcnRpY2FsLWFsaWduOiB0ZXh0LXRvcDtcbiAgICB9XG59XG5cbi5wbGF5bGlzdCB7XG4gICAgQGV4dGVuZCAlZGVza3RvcC1vbmx5O1xuXG4gICAgYmFja2dyb3VuZC1jb2xvcjogY29sb3Ioc2Vjb25kYXJ5KTtcbiAgICBjb2xvcjogI2ZmZjtcbiAgICBmb250LXNpemU6IDFyZW07XG4gICAgbWluLWhlaWdodDogZW0oMTUwKTtcbiAgICBwYWRkaW5nOiBlbSgxNSk7XG4gICAgd2lkdGg6IDEwMCU7XG59XG5cbi5wbGF5bGlzdF9fdGl0bGUtcm93IHtcbiAgICBhbGlnbi1pdGVtczogY2VudGVyO1xuICAgIGRpc3BsYXk6IGZsZXg7XG59XG5cbi5wbGF5bGlzdF9fdGl0bGUge1xuICAgIEBleHRlbmQgJW9zd2FsZDtcblxuICAgIGZvbnQtc2l6ZTogZW0oMjEpO1xuICAgIGxldHRlci1zcGFjaW5nOiAtLjVweDtcbiAgICB0ZXh0LXRyYW5zZm9ybTogdXBwZXJjYXNlO1xuXG4gICAgQG1lZGlhIHNjcmVlbiBhbmQgKG1pbi13aWR0aDogYnAobGFyZ2UpKSB7XG4gICAgICAgIGZvbnQtc2l6ZTogZW0oMjIpO1xuICAgIH1cbn1cblxuLnBsYXlsaXN0X19saW5rIHtcbiAgICBjdXJzb3I6IHBvaW50ZXI7XG4gICAgbWFyZ2luLWxlZnQ6IGF1dG87XG59XG5cbi5wbGF5bGlzdF9fdG90YWwge1xuICAgIEBleHRlbmQgJXNvdXJjZS1zYW5zLXNlbWktYm9sZC1pdGFsaWM7XG5cbiAgICBjb2xvcjogI2ZmZjtcbiAgICBmb250LXNpemU6IGVtKDE2KTtcbiAgICBtYXJnaW4tbGVmdDogZW0oNSk7XG4gICAgbWFyZ2luLXRvcDogZW0oNSk7XG59XG5cbi5wbGF5bGlzdF9faXRlbSB7XG4gICAgZGlzcGxheTogZmxleDtcbiAgICBtYXJnaW4tYm90dG9tOiBlbSgxMCk7XG59XG5cbi5wbGF5bGlzdF9faXRlbS1kZXNjIHtcbiAgICBiYWNrZ3JvdW5kLWNvbG9yOiBjb2xvcihsaWdodC1ncmV5KTtcbiAgICBjb2xvcjogY29sb3IoZGFyay1ncmV5KTtcbiAgICBmbGV4OiAxO1xuICAgIGZvbnQtc2l6ZTogZW0oMTApO1xuICAgIHBhZGRpbmc6IGVtKDcsMTApIGVtKDEwLDEwKTtcblxuICAgIEBtZWRpYSBzY3JlZW4gYW5kIChtaW4td2lkdGg6IGJwKGxhcmdlKSkge1xuICAgICAgICBmb250LXNpemU6IGVtKDEyKTtcbiAgICAgICAgcGFkZGluZzogZW0oNywxMikgZW0oMTAsMTIpO1xuICAgIH1cbn1cblxuLy8gUHJldiBhbmQgTmV4dCBNYXRjaCBTZWN0aW9uXG4ubWF0Y2gge1xuICAgIGJhY2tncm91bmQtY29sb3I6IGNvbG9yKHByaW1hcnkpO1xuICAgIGRpc3BsYXk6IGZsZXg7XG4gICAgaGVpZ2h0OiBlbSgzMCk7XG4gICAgcG9zaXRpb246IHJlbGF0aXZlO1xufVxuXG4ubWF0Y2hfX3ByZXYsXG4ubWF0Y2hfX25leHQge1xuICAgIGJhY2tncm91bmQtY29sb3I6IHRyYW5zcGFyZW50O1xuICAgIGNvbG9yOiBibGFjaztcbiAgICBkaXNwbGF5OiBmbGV4O1xufVxuXG4ubWF0Y2hfX3ByZXYtYnV0dG9uLFxuLm1hdGNoX19uZXh0LWJ1dHRvbiB7XG4gICAgQGV4dGVuZCAlc291cmNlLXNhbnM7XG5cbiAgICBhbGlnbi1pdGVtczogY2VudGVyO1xuICAgIGJhY2tncm91bmQtY29sb3I6IHRyYW5zcGFyZW50O1xuICAgIGNvbG9yOiAjZmZmO1xuICAgIGRpc3BsYXk6IGZsZXg7XG59XG5cbi5tYXRjaF9fcHJldi1idXR0b24gLm1hdGNoX19jb3B5IHtcbiAgICBtYXJnaW4tbGVmdDogNXB4O1xufVxuXG4ubWF0Y2hfX25leHQtYnV0dG9uIC5tYXRjaF9fY29weSB7XG4gICAgbWFyZ2luLXJpZ2h0OiA1cHg7XG59XG5cbi5tYXRjaF9fdGljay1saW5lIHtcbiAgICBiYWNrZ3JvdW5kLWNvbG9yOiBjb2xvcihncmV5KTtcbiAgICBmbGV4OiAxO1xuICAgIHBvc2l0aW9uOiByZWxhdGl2ZTtcbiAgICBoZWlnaHQ6IDJweDtcbiAgICBtYXJnaW46IGF1dG8gMDtcbn1cblxuLm1hdGNoX190aWNrIHtcbiAgICBiYWNrZ3JvdW5kLWNvbG9yOiAjZmZmO1xuICAgIGhlaWdodDogZW0oMTUpO1xuICAgIG1hcmdpbjogMGVtIDBlbSAwZW0gMGVtO1xuICAgIHBhZGRpbmc6IDBlbSAwZW0gMGVtIDBlbTtcbiAgICBwb3NpdGlvbjogYWJzb2x1dGU7XG4gICAgdG9wOiAtN3B4O1xuICAgIHdpZHRoOiAycHg7XG59XG5cbi5zdG9yeS1uYXYge1xuICAgIGJhY2tncm91bmQtY29sb3I6IGNvbG9yKGRhcmstZ3JleSk7XG4gICAgZGlzcGxheTogZmxleDtcbiAgICBoZWlnaHQ6IGVtKDMwKTtcbiAgICBqdXN0aWZ5LWNvbnRlbnQ6IHNwYWNlLWJldHdlZW47XG5cbiAgICBAbWVkaWEgc2NyZWVuIGFuZCAobWluLXdpZHRoOiBicChtZWRpdW0pICsgMSkge1xuICAgICAgICBiYWNrZ3JvdW5kLWNvbG9yOiB0cmFuc3BhcmVudDtcbiAgICB9XG59XG5cbi5zdG9yeS1uYXZfX3ByZXYsXG4uc3RvcnktbmF2X19uZXh0IHtcbiAgICBkaXNwbGF5OiBmbGV4O1xufVxuXG4uc3RvcnktbmF2X19wcmV2LWJ1dHRvbixcbi5zdG9yeS1uYXZfX25leHQtYnV0dG9uIHtcbiAgICBAZXh0ZW5kICVzb3VyY2Utc2FucztcblxuICAgIGFsaWduLWl0ZW1zOiBjZW50ZXI7XG4gICAgYmFja2dyb3VuZC1jb2xvcjogdHJhbnNwYXJlbnQ7XG4gICAgY29sb3I6ICNmZmY7XG4gICAgZGlzcGxheTogZmxleDtcblxuICAgIEBtZWRpYSBzY3JlZW4gYW5kIChtaW4td2lkdGg6IGJwKG1lZGl1bSkgKyAxKSB7XG4gICAgICAgIGNvbG9yOiBjb2xvcihkYXJrLWdyZXkpO1xuICAgIH1cbn1cblxuLnN0b3J5LW5hdl9fcHJldi1idXR0b24gLnN0b3J5LW5hdl9fY29weSB7XG4gICAgbWFyZ2luLWxlZnQ6IDVweDtcbn1cblxuLnN0b3J5LW5hdl9fbmV4dC1idXR0b24gLnN0b3J5LW5hdl9fY29weSB7XG4gICAgbWFyZ2luLXJpZ2h0OiA1cHg7XG59XG5cbi53aWRlU2NyZWVuIHtcbiAgICBtYXJnaW4tYm90dG9tOiAyMHB4O1xuICAgIHdpZHRoOiAxMDAlICFpbXBvcnRhbnQ7XG5cbiAgICAuYWJvdXQge1xuICAgICAgICBkaXNwbGF5OiBub25lO1xuICAgIH1cbn1cblxuLnRhYnMge1xuICAgIEBleHRlbmQgJW1vYmlsZS1vbmx5O1xuXG4gICAgYWxpZ24taXRlbXM6IGNlbnRlcjtcbiAgICBib3JkZXItYm90dG9tOiAxcHggc29saWQgY29sb3IoZ3JleSk7XG4gICAgZGlzcGxheTogZmxleDtcbiAgICBmb250LXNpemU6IHJlbSgxNik7XG4gICAgbWFyZ2luOiBlbSgxNCwgMTYpIGVtKDE1LCAxNikgMDtcblxuICAgIEBtZWRpYSBzY3JlZW4gYW5kICh3aWR0aDogNzY4cHgpIHtcbiAgICAgICAgZmxvYXQ6IGxlZnQ7XG4gICAgICAgIG1hcmdpbjogZW0oMTQsIDE2KSAwIDA7XG4gICAgICAgIHdpZHRoOiAxMDAlO1xuICAgIH1cbn1cblxuLnRhYnNfX3RhYiB7XG4gICAgQGV4dGVuZCAlc291cmNlLXNhbnMtYm9sZDtcblxuICAgIGJhY2tncm91bmQtY29sb3I6IGNvbG9yKGxpZ2h0LWdyZXkpO1xuICAgIGNvbG9yOiBjb2xvcihncmV5KTtcbiAgICBwYWRkaW5nOiBlbSgxMywgMTYpIGVtKDEwLCAxNik7XG4gICAgdGV4dC10cmFuc2Zvcm06IHVwcGVyY2FzZTtcblxuICAgICY6aG92ZXIge1xuICAgICAgICBjdXJzb3I6IHBvaW50ZXI7XG4gICAgfVxuXG4gICAgJi0tYWN0aXZlIHtcbiAgICAgICAgYmFja2dyb3VuZC1jb2xvcjogY29sb3Ioc2Vjb25kYXJ5KTtcbiAgICAgICAgY29sb3I6ICNmZmY7XG4gICAgfVxufVxuXG4udGFic19fYWRkLXN0b3J5IHtcbiAgICBtYXJnaW4tbGVmdDogYXV0bztcbn1cblxuLnRhYnNfX3BsYXlsaXN0LWJ1dHRvbnMgeyBtYXJnaW4tbGVmdDogYXV0bzsgfVxuXG4udGFic19fcGxheWxpc3QtYnV0dG9ucyB7XG4gICAgYWxpZ24taXRlbXM6IGNlbnRlcjtcbiAgICBkaXNwbGF5OiBmbGV4O1xuICAgIGhlaWdodDogZW0oMzUpO1xuICAgIGp1c3RpZnktY29udGVudDogY2VudGVyO1xuICAgIHBvc2l0aW9uOiByZWxhdGl2ZTtcbiAgICB3aWR0aDogZW0oMzUpO1xufVxuXG4udGFic19fdG9vbHRpcCB7XG4gICAgZm9udC1zaXplOiByZW0oMTIpO1xuICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcbiAgICByaWdodDogZW0oNDAsIDEyKTtcbiAgICBiYWNrZ3JvdW5kOiBjb2xvcihzZWNvbmRhcnkpO1xuICAgIGNvbG9yOiB3aGl0ZTtcbiAgICB0ZXh0LWFsaWduOiBjZW50ZXI7XG4gICAgcGFkZGluZzogZW0oOCwgMTIpO1xuICAgIHRvcDogMDtcbiAgICBib3JkZXItcmFkaXVzOiBlbSgzLCAxMik7XG4gICAgd2hpdGUtc3BhY2U6IG5vd3JhcDtcblxuICAgICY6OmJlZm9yZSB7XG4gICAgICAgIGJvcmRlci1ib3R0b206IDVweCBzb2xpZCB0cmFuc3BhcmVudDtcbiAgICAgICAgYm9yZGVyLWxlZnQ6IDVweCBzb2xpZCBjb2xvcihzZWNvbmRhcnkpO1xuICAgICAgICBib3JkZXItdG9wOiA1cHggc29saWQgdHJhbnNwYXJlbnQ7XG4gICAgICAgIGNvbnRlbnQ6IFwiIFwiO1xuICAgICAgICBoZWlnaHQ6IDA7XG4gICAgICAgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcbiAgICAgICAgcmlnaHQ6IC0gZW0oNCwgMTIpO1xuICAgICAgICB0b3A6IGVtKDEzLCAxMik7XG4gICAgICAgIHdpZHRoOiAwO1xuICAgICAgICB3aGl0ZS1zcGFjZTogbm93cmFwO1xuICAgIH1cbn1cblxuLmFkanVzdC1oZWlnaHQge1xuICBvdmVyZmxvdy14OiBoaWRkZW47XG4gIG92ZXJmbG93LXk6IGF1dG87XG59XG5cbi5uZXh0LXZpZF9fcm93IHtcbiAgZGlzcGxheTogZmxleDtcblxuICAmOmhvdmVyIHtcbiAgICBjdXJzb3I6IHBvaW50ZXI7XG4gIH1cbn1cblxuLnZpZGVvX190aXRsZSxcbi5uZXh0LXZpZF9fdGl0bGUge1xuICBjb2xvcjogY29sb3Ioc2Vjb25kYXJ5KTtcbiAgZm9udC13ZWlnaHQ6IDcwMDtcbn1cblxuLnZpZGVvX190aXRsZSB7IGZvbnQtc2l6ZTogcmVtKDE4KTsgfVxuXG4ubmV4dC12aWRfX3ByZXZpZXc6aG92ZXIge1xuICBjdXJzb3I6IHBvaW50ZXI7XG59XG5cbi5uZXh0LXZpZF9fdGh1bWIge1xuICBmb250LXNpemU6IHJlbSgxNCk7XG4gIG1heC13aWR0aDogMTAwJTtcbn1cblxuLm5leHQtdmlkX19kYS1idXR0b24ge1xuICBAZXh0ZW5kICVvc3dhbGQ7XG4gIGJhY2tncm91bmQtY29sb3I6ICM2ODIwNTI7XG4gIGJvcmRlcjogMXB4IHNvbGlkIHRyYW5zcGFyZW50O1xuICBjb2xvcjogI2ZmZjtcbiAgZGlzcGxheTogYmxvY2s7XG4gIGZvbnQtc2l6ZTogcmVtKDI1KTtcbiAgZm9udC13ZWlnaHQ6IDQwMDtcbiAgbGluZS1oZWlnaHQ6IDEuMjtcbiAgcGFkZGluZzogZW0oMTUsIDI1KTtcbiAgbWFyZ2luLXRvcDogZW0oMTAsIDI1KTtcbiAgdHJhbnNpdGlvbjogYWxsIC4ycyBlYXNlLWluLW91dDtcblxuICAmOmhvdmVyIHtcbiAgICBiYWNrZ3JvdW5kLWNvbG9yOiAjZmZmO1xuICAgIGJvcmRlcjogMXB4IHNvbGlkICM2ODIwNTI7XG4gICAgY29sb3I6ICM2ODIwNTI7XG4gICAgdGV4dC1kZWNvcmF0aW9uOiBub25lO1xuICB9XG59XG5cblxuIiwiLy8gbWFwc1xuXG4kYnJlYWtwb2ludHM6IChcbiAgc21hbGw6IDU0NHB4LFxuICBtZWRpdW06IDc2OHB4LFxuICBsYXJnZTogMTIwMHB4XG4pO1xuXG4kY29sb3JzOiAoXG4gIHByaW1hcnk6ICMyRTJCNzEsXG4gIHNlY29uZGFyeTogIzk0MUExRCxcbiAgdGVydGlhcnk6ICNmMDUxMWYsXG4gIGxpZ2h0LWdyZXk6ICNmMGYwZjAsXG4gIGdyZXk6ICNjY2NjY2MsXG4gIGRhcmstZ3JleTogIzIzMjMyM1xuKTtcblxuLy8gZm9udCBwbGFjZWhvbGRlcnNcblxuJXNvdXJjZS1zYW5zIHtcbiAgZm9udC1mYW1pbHk6ICdTb3VyY2UgU2FucyBQcm8nLCBzYW5zLXNlcmlmO1xufVxuXG4lc291cmNlLXNhbnMtc2VtaS1ib2xkIHtcbiAgZm9udC1mYW1pbHk6ICdTb3VyY2UgU2FucyBQcm8nLCBzYW5zLXNlcmlmO1xuICBmb250LXdlaWdodDogNjAwO1xufVxuXG4lc291cmNlLXNhbnMtc2VtaS1ib2xkLWl0YWxpYyB7XG4gIGZvbnQtZmFtaWx5OiAnU291cmNlIFNhbnMgUHJvJywgc2Fucy1zZXJpZjtcbiAgZm9udC1zdHlsZTogaXRhbGljO1xuICBmb250LXdlaWdodDogNjAwO1xufVxuXG4lc291cmNlLXNhbnMtYm9sZCB7XG4gIGZvbnQtZmFtaWx5OiAnU291cmNlIFNhbnMgUHJvJywgc2Fucy1zZXJpZjtcbiAgZm9udC13ZWlnaHQ6IDcwMDtcbn1cblxuJXNvdXJjZS1zYW5zLWJvbGQtaXRhbGljIHtcbiAgZm9udC1mYW1pbHk6ICdTb3VyY2UgU2FucyBQcm8nLCBzYW5zLXNlcmlmO1xuICBmb250LXN0eWxlOiBpdGFsaWM7XG4gIGZvbnQtd2VpZ2h0OiA3MDA7XG59XG5cbiVvc3dhbGQge1xuICBmb250LWZhbWlseTogJ09zd2FsZCcsIHNhbnMtc2VyaWY7XG4gIGZvbnQtd2VpZ2h0OiA1MDA7XG59XG5cbi8vSGVhZGVyIFBsYWNlaG9sZGVyc1xuXG4laGVhZGVyLTEge1xuICAgIEBleHRlbmQgJW9zd2FsZDtcbiAgICBjb2xvcjogIzFFMTgxMDtcbiAgICBmb250LXNpemU6IDEuODU3MTRyZW07XG4gICAgbGluZS1oZWlnaHQ6IDEuMjIyMjJlbTtcbiAgICBtYXJnaW46IDAgMCAyLjIzMDc3ZW07XG4gICAgdGV4dC10cmFuc2Zvcm06IHVwcGVyY2FzZTtcbn1cblxuLmhlYWRlci0xIHtcbiAgICBAZXh0ZW5kICVvc3dhbGQ7XG4gICAgY29sb3I6IGNvbG9yKGRhcmstZ3JleSk7XG4gICAgZm9udC1zaXplOiAxLjg1NzE0cmVtO1xuICAgIGxpbmUtaGVpZ2h0OiAxLjIyMjIyZW07XG4gICAgbWFyZ2luOiAwIDAgMi4yMzA3N2VtO1xuICAgIHRleHQtdHJhbnNmb3JtOiB1cHBlcmNhc2U7XG59XG5cbiVoZWFkZXItMiB7XG4gICAgQGV4dGVuZCAlb3N3YWxkO1xuICAgIGNvbG9yOiBjb2xvcihkYXJrLWdyZXkpO1xuICAgIGZvbnQtc2l6ZTogMS41NzE0M2VtO1xuICAgIGxpbmUtaGVpZ2h0OiAyNnB4O1xuICAgIG1hcmdpbjogMCAwIDAuNzE0MjllbTtcbiAgICBwYWRkaW5nOiAwO1xufVxuXG4uaGVhZGVyLTIge1xuICBAZXh0ZW5kICVvc3dhbGQ7XG4gIGNvbG9yOiBjb2xvcihkYXJrLWdyZXkpO1xuICBmb250LXNpemU6IDEuNTcxNDNlbTtcbiAgbGluZS1oZWlnaHQ6IDI2cHg7XG4gIG1hcmdpbjogMCAwIDAuNzE0MjllbTtcbiAgcGFkZGluZzogMDtcbn1cblxuJWhlYWRlci0zIHtcbiAgICBAZXh0ZW5kICVvc3dhbGQ7XG4gICAgY29sb3I6IGNvbG9yKGRhcmstZ3JleSk7XG4gICAgZm9udC1zaXplOiBlbSgyMik7XG4gICAgbWFyZ2luLWJvdHRvbTogMDtcbiAgICBtYXJnaW4tdG9wOiAwO1xuICAgIHBhZGRpbmctYm90dG9tOiAxLjExMTExZW07XG4gICAgcGFkZGluZy10b3A6IDA7XG59XG5cbi5oZWFkZXItMyB7XG4gICAgQGV4dGVuZCAlb3N3YWxkO1xuICAgIGNvbG9yOiBjb2xvcihkYXJrLWdyZXkpO1xuICAgIGZvbnQtc2l6ZTogZW0oMjIpO1xuICAgIG1hcmdpbi1ib3R0b206IDA7XG4gICAgbWFyZ2luLXRvcDogMDtcbiAgICBwYWRkaW5nLWJvdHRvbTogMS4xMTExMWVtO1xuICAgIHBhZGRpbmctdG9wOiAwO1xufVxuXG4laGVhZGVyLTQge1xuICAgIEBleHRlbmQgJW9zd2FsZDtcbiAgICBjb2xvcjogY29sb3IoZGFyay1ncmV5KTtcbiAgICBmb250LXNpemU6IGVtKDIyKTtcbiAgICBtYXJnaW46IDAgMCAwLjNlbTtcbiAgICBwYWRkaW5nOiAwO1xufVxuXG4uaGVhZGVyLTQge1xuICAgIEBleHRlbmQgJW9zd2FsZDtcbiAgICBjb2xvcjogY29sb3IoZGFyay1ncmV5KTtcbiAgICBmb250LXNpemU6IGVtKDIyKTtcbiAgICBtYXJnaW46IDAgMCAwLjNlbTtcbiAgICBwYWRkaW5nOiAwO1xufVxuIiwiQGZ1bmN0aW9uIGNvbG9yKCRrZXkpIHtcbiAgQGlmIG1hcC1oYXMta2V5KCRjb2xvcnMsICRrZXkpIHtcbiAgICBAcmV0dXJuIG1hcC1nZXQoJGNvbG9ycywgJGtleSk7XG4gIH1cblxuICBAd2FybiBcIlVua25vd24gYCN7JGtleX1gIGtleSBpbiAkY29sb3JzLlwiO1xuICBAcmV0dXJuIG51bGw7XG59XG5cbkBmdW5jdGlvbiBicCgka2V5KSB7XG4gIEBpZiBtYXAtaGFzLWtleSgkYnJlYWtwb2ludHMsICRrZXkpIHtcbiAgICBAcmV0dXJuIG1hcC1nZXQoJGJyZWFrcG9pbnRzLCAka2V5KTtcbiAgfVxuXG4gIEB3YXJuIFwiVW5rbm93biBgI3ska2V5fWAga2V5IGluICRicmVha3BvaW50cy5cIjtcbiAgQHJldHVybiBudWxsO1xufVxuXG4kYnJvd3Nlci1jb250ZXh0OiAxNDtcblxuQGZ1bmN0aW9uIGVtKCRwaXhlbHMsICRjb250ZXh0OiAkYnJvd3Nlci1jb250ZXh0KSB7XG4gIEBpZiAodW5pdGxlc3MoJHBpeGVscykpIHtcbiAgICAkcGl4ZWxzOiAkcGl4ZWxzICogMXB4O1xuICB9XG5cbiAgQGlmICh1bml0bGVzcygkY29udGV4dCkpIHtcbiAgICAkY29udGV4dDogJGNvbnRleHQgKiAxcHg7XG4gIH1cblxuICBAcmV0dXJuICRwaXhlbHMgLyAkY29udGV4dCAqIDFlbTtcbn1cblxuQGZ1bmN0aW9uIHJlbSgkcGl4ZWxzLCAkY29udGV4dDogJGJyb3dzZXItY29udGV4dCkge1xuICBAaWYgKHVuaXRsZXNzKCRwaXhlbHMpKSB7XG4gICAgJHBpeGVsczogJHBpeGVscyAqIDFweDtcbiAgfVxuXG4gIEBpZiAodW5pdGxlc3MoJGNvbnRleHQpKSB7XG4gICAgJGNvbnRleHQ6ICRjb250ZXh0ICogMXB4O1xuICB9XG5cbiAgQHJldHVybiAkcGl4ZWxzIC8gJGNvbnRleHQgKiAxcmVtO1xufSIsIi8vIEhlbHBlciBjbGFzc2VzXG4vLyAtLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxuLy8gQ2xhc3NlcyB0byB1c2UgZm9yIHNtYWxsLCBjb21tb24gdGFza3MuIElmIHVzZWQgaW4gY29uanVuY3Rpb25cbi8vIHdpdGggb3RoZXIgc3R5bGVzLCBwbGVhc2UgY3JlYXRlIGEgY2xhc3MgYW5kIGV4dGVuZCB0aGUgcGxhY2Vob2xkZXIuXG5cbi5ib2xkLFxuJWJvbGQgeyBmb250LXdlaWdodDogNzAwOyB9XG5cbi5pdGFsaWMsXG4laXRhbGljIHsgZm9udC1zdHlsZTogaXRhbGljOyB9XG5cbiVsaXN0LXdpdGhvdXQtc3R5bGVzLFxuLmxpc3Qtd2l0aG91dC1zdHlsZXMge1xuICBsaXN0LXN0eWxlLXR5cGU6IG5vbmU7XG4gIHBhZGRpbmc6IDA7XG59XG5cbiVtb2JpbGUtb25seSxcbi5tb2JpbGUtb25seSB7XG4gIEBtZWRpYSBzY3JlZW4gYW5kIChtaW4td2lkdGg6IDc2OXB4KSB7XG4gICAgZGlzcGxheTogbm9uZSAhaW1wb3J0YW50O1xuICB9XG59XG5cbiV0YWJsZXQtYW5kLWFib3ZlLFxuLnRhYmxldC1hbmQtYWJvdmUge1xuICBAbWVkaWEgc2NyZWVuIGFuZCAobWF4LXdpZHRoOiBicChzbWFsbCkpIHtcbiAgICBkaXNwbGF5OiBub25lICFpbXBvcnRhbnQ7XG4gIH1cbn1cblxuJWRlc2t0b3Atb25seSxcbi5kZXNrdG9wLW9ubHkge1xuICBAbWVkaWEgc2NyZWVuIGFuZCAobWF4LXdpZHRoOiA3NjhweCkge1xuICAgIGRpc3BsYXk6IG5vbmUgIWltcG9ydGFudDtcbiAgfVxufVxuXG4lbGltaXRlZC10ZXh0IHtcbiAgICAtd2Via2l0LWJveC1vcmllbnQ6IHZlcnRpY2FsO1xuICAgIC13ZWJraXQtbGluZS1jbGFtcDogMztcbiAgICBkaXNwbGF5OiAtd2Via2l0LWJveDtcbiAgICBsaW5lLWhlaWdodDogMS4xZW07XG4gICAgb3ZlcmZsb3c6IGhpZGRlbjtcbiAgICB0ZXh0LW92ZXJmbG93OiBlbGxpcHNpcztcbn0iLCJAaW1wb3J0ICdmdW5jdGlvbnMnO1xuQGltcG9ydCAndmFyaWFibGVzJztcbkBpbXBvcnQgJ2hlbHBlcnMnO1xuXG4vLyBib290c3RyYXAgb3ZlcnJpZGVzXG5cbi5jb250YWluZXItZmx1aWQge1xuICAgIGZvbnQtc2l6ZTogMXJlbTtcbiAgICBwYWRkaW5nLXRvcDogZW0oMTYpO1xuICAgIHBhZGRpbmctYm90dG9tOiBlbSgxNik7XG4gICAgbWF4LXdpZHRoOiBlbSgxNTAwKTtcblxuICAgICY6Zm9jdXMge1xuICAgICAgICBvdXRsaW5lOiAwO1xuICAgIH1cblxuICAgIEBtZWRpYSBzY3JlZW4gYW5kIChtaW4td2lkdGg6IGJwKHNtYWxsKSkge1xuICAgICAgICBwYWRkaW5nLXRvcDogZW0oMzApO1xuICAgIH1cblxuICAgIEBtZWRpYSBzY3JlZW4gYW5kIChtaW4td2lkdGg6IGJwKG1lZGl1bSkpIHtcbiAgICAgICAgcGFkZGluZy1sZWZ0OiBlbSgzMCk7XG4gICAgICAgIHBhZGRpbmctcmlnaHQ6IGVtKDMwKTtcbiAgICAgICAgcGFkZGluZy1ib3R0b206IGVtKDMwKTtcbiAgICB9XG59Il19 */"]
      });
      /***/
    },

    /***/
    "ZAI4":
    /*!*******************************!*\
      !*** ./src/app/app.module.ts ***!
      \*******************************/

    /*! exports provided: AppModule */

    /***/
    function ZAI4(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony export (binding) */


      __webpack_require__.d(__webpack_exports__, "AppModule", function () {
        return AppModule;
      });
      /* harmony import */


      var _angular_platform_browser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/platform-browser */
      "jhN1");
      /* harmony import */


      var _angular_forms__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @angular/forms */
      "3Pt+");
      /* harmony import */


      var _angular_common_http__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! @angular/common/http */
      "tk/3");
      /* harmony import */


      var _videogular_ngx_videogular_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! @videogular/ngx-videogular/core */
      "4w57");
      /* harmony import */


      var _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(
      /*! @videogular/ngx-videogular/controls */
      "v2j/");
      /* harmony import */


      var _videogular_ngx_videogular_overlay_play__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(
      /*! @videogular/ngx-videogular/overlay-play */
      "cqME");
      /* harmony import */


      var _videogular_ngx_videogular_buffering__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(
      /*! @videogular/ngx-videogular/buffering */
      "VKRg");
      /* harmony import */


      var _scroll_transcript_directive__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(
      /*! ./scroll-transcript.directive */
      "4yKC");
      /* harmony import */


      var _app_component__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(
      /*! ./app.component */
      "Sy1n");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");

      var AppModule = function AppModule() {
        _classCallCheck(this, AppModule);
      };

      AppModule.ɵfac = function AppModule_Factory(t) {
        return new (t || AppModule)();
      };

      AppModule.ɵmod = _angular_core__WEBPACK_IMPORTED_MODULE_9__["ɵɵdefineNgModule"]({
        type: AppModule,
        bootstrap: [_app_component__WEBPACK_IMPORTED_MODULE_8__["AppComponent"]]
      });
      AppModule.ɵinj = _angular_core__WEBPACK_IMPORTED_MODULE_9__["ɵɵdefineInjector"]({
        providers: [],
        imports: [[_angular_platform_browser__WEBPACK_IMPORTED_MODULE_0__["BrowserModule"], _angular_forms__WEBPACK_IMPORTED_MODULE_1__["FormsModule"], _angular_common_http__WEBPACK_IMPORTED_MODULE_2__["HttpClientModule"], _videogular_ngx_videogular_core__WEBPACK_IMPORTED_MODULE_3__["VgCoreModule"], _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_4__["VgControlsModule"], _videogular_ngx_videogular_overlay_play__WEBPACK_IMPORTED_MODULE_5__["VgOverlayPlayModule"], _videogular_ngx_videogular_buffering__WEBPACK_IMPORTED_MODULE_6__["VgBufferingModule"]]]
      });

      (function () {
        (typeof ngJitMode === "undefined" || ngJitMode) && _angular_core__WEBPACK_IMPORTED_MODULE_9__["ɵɵsetNgModuleScope"](AppModule, {
          declarations: [_app_component__WEBPACK_IMPORTED_MODULE_8__["AppComponent"], _scroll_transcript_directive__WEBPACK_IMPORTED_MODULE_7__["ScrollTranscript"]],
          imports: [_angular_platform_browser__WEBPACK_IMPORTED_MODULE_0__["BrowserModule"], _angular_forms__WEBPACK_IMPORTED_MODULE_1__["FormsModule"], _angular_common_http__WEBPACK_IMPORTED_MODULE_2__["HttpClientModule"], _videogular_ngx_videogular_core__WEBPACK_IMPORTED_MODULE_3__["VgCoreModule"], _videogular_ngx_videogular_controls__WEBPACK_IMPORTED_MODULE_4__["VgControlsModule"], _videogular_ngx_videogular_overlay_play__WEBPACK_IMPORTED_MODULE_5__["VgOverlayPlayModule"], _videogular_ngx_videogular_buffering__WEBPACK_IMPORTED_MODULE_6__["VgBufferingModule"]]
        });
      })();
      /***/

    },

    /***/
    "zUnb":
    /*!*********************!*\
      !*** ./src/main.ts ***!
      \*********************/

    /*! no exports provided */

    /***/
    function zUnb(module, __webpack_exports__, __webpack_require__) {
      "use strict";

      __webpack_require__.r(__webpack_exports__);
      /* harmony import */


      var _angular_platform_browser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(
      /*! @angular/platform-browser */
      "jhN1");
      /* harmony import */


      var _angular_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(
      /*! @angular/core */
      "fXoL");
      /* harmony import */


      var _app_app_module__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(
      /*! ./app/app.module */
      "ZAI4");
      /* harmony import */


      var _environments_environment__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(
      /*! ./environments/environment */
      "AytR");

      if (_environments_environment__WEBPACK_IMPORTED_MODULE_3__["environment"].production) {
        Object(_angular_core__WEBPACK_IMPORTED_MODULE_1__["enableProdMode"])();
      }

      var INTERPOLATION_REGEXP = /\{\{([\s\S]*?)\}\}/g; // default

      _angular_platform_browser__WEBPACK_IMPORTED_MODULE_0__["platformBrowser"]().bootstrapModule(_app_app_module__WEBPACK_IMPORTED_MODULE_2__["AppModule"]);
      /***/

    },

    /***/
    "zn8P":
    /*!******************************************************!*\
      !*** ./$$_lazy_route_resource lazy namespace object ***!
      \******************************************************/

    /*! no static exports found */

    /***/
    function zn8P(module, exports) {
      function webpackEmptyAsyncContext(req) {
        // Here Promise.resolve().then() is used instead of new Promise() to prevent
        // uncaught exception popping up in devtools
        return Promise.resolve().then(function () {
          var e = new Error("Cannot find module '" + req + "'");
          e.code = 'MODULE_NOT_FOUND';
          throw e;
        });
      }

      webpackEmptyAsyncContext.keys = function () {
        return [];
      };

      webpackEmptyAsyncContext.resolve = webpackEmptyAsyncContext;
      module.exports = webpackEmptyAsyncContext;
      webpackEmptyAsyncContext.id = "zn8P";
      /***/
    }
  }, [[0, "runtime", "vendor"]]]);
})();
//# sourceMappingURL=main-es5.js.map