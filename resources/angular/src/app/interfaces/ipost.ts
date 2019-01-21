export interface IPost {
    id: number,
    title: string,
    description: string,
    body: string,
    author_id: string,
    is_sticky: number,
    created_at?: string,
    status: number,
    categories: number[]
}
