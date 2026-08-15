export type Review = {
  id: number;
  author: string;
  initials: string;
  rating: number;
  title: string;
  body: string;
  date: string;
  helpfulCount: number;
  verifiedExperience?: boolean;
  disclaimer?: string;
  serviceRating?: number;
  valueRating?: number;
  commRating?: number;
  discussionCount?: number;
};

export type Business = {
  id: number;
  slug: string;
  name: string;
  bengaliName?: string;
  category: string;
  description: string;
  location: string;
  rating: number;
  reviewCount: number;
  verified: boolean;
  phone: string;
  website: string;
  color?: string;
  image?: string;
  branches?: string[];
  reviews: Review[];
  distribution: number[];
  ratingCounts?: { star5: number; star4: number; star3: number; star2: number; star1: number };
};

export type TimelineEvent = {
  date: string;
  title: string;
  desc: string;
  done?: boolean;
};

export type ScamAlert = {
  id: number;
  caseCode?: string;
  slug: string;
  title?: string;
  entity: string;
  category: string;
  status: "Published" | "Resolved" | "Business Responded" | "Under Review";
  summary: string;
  date: string;
  amount?: string;
  trxId?: string;
  evidence: string;
  response: boolean;
  image?: string;
  reporterAlias?: string;
  merchantContact?: string;
  timeline?: TimelineEvent[];
};

export type User = {
  id: number;
  name: string;
  email: string;
  avatar_url?: string | null;
  role: "user" | "moderator" | "admin";
  email_verified_at: string | null;
  created_at: string;
};
