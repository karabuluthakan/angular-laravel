export interface IPage {
    id: number,
    title: string,
    description: string,
    body: string,
    parent: number,
    created_at?: string,
    status: number,
}
