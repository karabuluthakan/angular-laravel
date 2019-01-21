import {IPageLinks} from "./ipage-links";

export interface IResponse {
    status: number,
    message?: string,
    data?: any,
    pageLinks?: IPageLinks
}
