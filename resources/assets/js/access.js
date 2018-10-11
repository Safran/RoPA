/*
  * This file is part of the Record of processing activities project.
  * Its original location is https://github.com/Safran/RoPA
  * 
  * SPDX-License-Identifier: GPL-3.0-only
  */


let user = window.App.user;

module.exports = {
    supervized(model, prop = 'supervisor_id') {
        return parseInt(model[prop]) === user.id || user.role === 'admin';
    },
};
