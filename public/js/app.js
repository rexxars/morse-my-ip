'use strict';

var Modernizr = require('imports?window=>exports!./modernizr').Modernizr;
var MorseNode = require('./morse-node');

var useAudio = (window.location.search || '').indexOf('noaudio') === -1;
var hasAudioApi = window.AudioContext || window.webkitAudioContext;

if (useAudio) {
    setupAudio(determineMethod());
}

function determineMethod() {
    var urlMethod = (window.location.search || '').replace(/.*method=([a-z0-9]+).*/, '$1');
    var ua = navigator.userAgent;
    var iOS = /iPad/i.test(ua) || /iPhone/i.test(ua) || /iPod/i.test(ua);

    if (urlMethod) {
        return urlMethod;
    } else if (hasAudioApi) {
        return 'generated';
    } else if (Modernizr.audio && Modernizr.audio.wav && !iOS) {
        return 'html5audio';
    } else if (iOS) {
        return 'audioiframe';
    } else if (window.morseMyIp.isOldIE) {
        return 'bgsound';
    }

    return 'object';
}

function setupAudio(method) {
    var audioControls = document.getElementById('audio-controls');

    switch (method) {
        case 'generated':
            return playGeneratedAudio();
        case 'html5audio':
            return audioControls.appendChild(createAudioElement());
        case 'audioiframe':
            return audioControls.appendChild(createAudioIframe());
        case 'object':
            return audioControls.appendChild(createAudioObject());
        default:
            return;
    }
}

function createAudioElement() {
    var audio = document.createElement('audio');
    audio.setAttribute('src', 'morse.wav');
    audio.setAttribute('autoplay', 'autoplay');
    return audio;
}

function createAudioIframe() {
    var iframe = document.createElement('iframe');
    iframe.setAttribute('src', 'morse.wav');
    return iframe;
}

function createAudioObject() {
    var object = document.createElement('object');
    object.setAttribute('data', 'morse.wav');
    return object;
}

function playGeneratedAudio() {
    var ac = new (window.AudioContext || window.webkitAudioContext)();

    var morse = new MorseNode(ac);
    var gainNode = ac.createGain();
    gainNode.gain.value = 0.2;

    morse.connect(gainNode);
    gainNode.connect(ac.destination);
    morse.playString(ac.currentTime, window.morseMyIp.clientIP || '');
}
