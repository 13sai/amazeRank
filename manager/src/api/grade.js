import request from '@/utils/request'

export function getList(params) {
  return request({
    url: '/grade/rank',
    method: 'get',
    params: params
  })
}

export function cleanData() {
    return request({
      url: `/grade/clean`,
      method: 'delete',
    })
  }
