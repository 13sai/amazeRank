import request from '@/utils/request'

export function fetchSetting(type, query) {
    return request({
        url: `/settings/${type}`,
        method: 'get',
        params: query
    })
}

export function updateSetting(query) {
    return request({
        url: '/setting',
        method: 'put',
        params: query
    })
}


export function fetchAdminList(query) {
    return request({
        url: '/admin/list',
        method: 'get',
        params: query
    })
}

export function fetchAdmin(query) {
    return request({
        url: '/admin',
        method: 'get',
        params: query
    })
}

export function updateAdmin(query) {
    return request({
        url: '/admin',
        method: 'put',
        params: query
    })
}

export function deleteAdmin(query) {
    return request({
        url: '/admin',
        method: 'delete',
        params: query
    })
}

export function addAdmin(query) {
    return request({
        url: '/admin',
        method: 'post',
        params: query
    })
}
