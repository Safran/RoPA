/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


export function isObject(obj) {
    return obj !== null && typeof obj === 'object';
}

export function looseIndexOf(arr, val)
{
    for (let i = 0; i < arr.length; i++) {
        if (looseEqual(arr[i], val)) {
            return i;
        }
    }

    return -1;
}

export function looseEqual(a, b) {
    return a == b || (
        isObject(a) && isObject(b) ? JSON.stringify(a) === JSON.stringify(b) : false
    );
}

export function fullPath(path)
{
    return window.App.baseURL + '/' + window.App.locale + path;
}