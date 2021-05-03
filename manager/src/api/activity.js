import request from '@/utils/request'


export function getList(params) {
  return request({
    url: '/activitys',
    method: 'get',
    params: params
  })
}

export function edit(id, data) {
  return request({
    url: `/activity/${id}`,
    method: 'put',
    data
  })
}

export function sort(id, data) {
  return request({
    url: `/activity/${id}`,
    method: 'post',
    data
  })
}

export function del(id) {
  return request({
    url: `/activity/${id}`,
    method: 'delete',
  })
}
