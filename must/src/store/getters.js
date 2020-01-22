export const getUser = state => { 
    //return state.userInfo ;
    return {
        level: "100",
        name: "陳昱宏",
        isAdmin: 1,
        id:1}
}

export const getJob = state => { 
    return state.jobOpts ;
}