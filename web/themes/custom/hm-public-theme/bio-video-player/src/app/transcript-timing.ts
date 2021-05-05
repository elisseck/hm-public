export class TranscriptTiming {
  public offset: number;
  public time: number;

  constructor() {
    this.offset = 0;
    this.time = 0;
  }

  buildFromArray(timingPairArray){
    let myTime = Number(timingPairArray[0]);
    let myOffset = Number(timingPairArray[1]);
    if(!isNaN(myTime))
      this.time = myTime;
    if(!isNaN(myOffset))
      this.offset = myOffset;
    return this;
  }
}
