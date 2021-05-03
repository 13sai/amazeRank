import request from '@/utils/request'

export function BannerList(query) {
    return request({
        url: '/bannerList',
        method: 'get',
        params: query
    })
}

export function addBanner(query) {
    var q = JSON.parse(JSON.stringify(query));
    q.start_time = (new Date(q.start_time)).getTime()
    q.over_time = (new Date(q.over_time)).getTime()
    return request({
        url: '/banner',
        method: 'post',
        params: q
    })
}

export function updateBanner(query) {
    var q = JSON.parse(JSON.stringify(query));
    q.start_time = (new Date(q.start_time)).getTime()
    q.over_time = (new Date(q.over_time)).getTime()
    return request({
        url: '/banner',
        method: 'put',
        params: q
    })
}


export function deleteBanner(query) {
    return request({
        url: '/banner',
        method: 'delete',
        params: query
    })
}

export function showBanner(query) {
    return request({
        url: '/showBanner',
        method: 'put',
        params: query
    })
}
