export interface IRequest {
    _token?: string,
    job: string,
    data: object,
    page?: number,
    filter?: object,
    sorting?: object
}
