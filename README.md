## DB Web Programming 팀프로젝트 - 중고 플랫폼 통합 조회 서비스
<img width="361" alt="image" src="https://user-images.githubusercontent.com/74501631/235022596-b3a800ac-e4a1-4a44-8481-0cbb2b9a30b8.png">
(2022.04 ~ 2022.05)
<br/>

### Main Description
- 당근마켓, 중고나라, 번개장터 API 및 크롤링 후 MySQL에 중고 데이터 수집
- 특정 키워드를 검색했을 때 검색 결과를 가격 오름차순으로 정렬하고, 극단값을 제거해서 평균값(시세) 계산

<br/>
<br/>

### Environment

#### 1. Data Processing

##### Python
 - Load the sales posts on each site.
 - The crawled items : site name, post title, price, image, creation date,  post link.
 - Each site collects 200,000 data.
 - Accumulate data and show it in real time to crawled every specific time.
 
 ##### MySQL
 - Preprocess the crawled data as MySQL. (Uniform column shape, and delete unnecessary data & null value).

#### 2. Implement Web page

##### Php
 - connect the MySQL Database
 - Implement a page that shows search results in the latest order (default).
 - Settings made to divide pages: The maximum number of posts that can appear in the list, the number of pages that will be displayed on one screen.
 - Use Sql's from clause subquery to get only the list corresponding to each page from the extreme value removed table.
 - Implement bottom page nation.
 - Show list in ascending order with order price or latest date.
 

 <br/>


### Result

 ![image1](https://user-images.githubusercontent.com/74501631/235025013-cf139ae3-49c6-4563-9a1f-d8b3cd0a8527.png)
 <br/>
 ![image2](https://user-images.githubusercontent.com/74501631/235025052-7736779c-317d-42d7-8e06-db89079f7369.png)
 <br/>
 ![image3](https://user-images.githubusercontent.com/74501631/235025080-4f068dab-15f2-49fb-bf5c-cd3aa27453b5.png)
 <br/>
 ![image4](https://user-images.githubusercontent.com/74501631/235025095-2ebd89b7-72b7-41be-8c75-fae25bd77c3e.png)
 <br/>
 <br/>
 click the items -> go link to merchandise page
 ![image5](https://user-images.githubusercontent.com/74501631/235025225-d1edaa71-8aa4-48f6-9484-ab739131dfc2.png)
